<?php declare(strict_types=1);

namespace Alamirault\FFTTApi\Service\Operation;

use Alamirault\FFTTApi\Model\Classement;
use Alamirault\FFTTApi\Model\Partie;
use Alamirault\FFTTApi\Model\UnvalidatedPartie;
use Alamirault\FFTTApi\Service\FFTTClientInterface;
use Alamirault\FFTTApi\Service\NomPrenomExtractorInterface;
use DateTime;

final class ListPartieOperation
{
    private const JOUR_DEBUT_MOIS_VIRTUEL = 5;
    /**
     * @readonly
     * @var \Alamirault\FFTTApi\Service\FFTTClientInterface
     */
    private $client;
    /**
     * @readonly
     * @var \Alamirault\FFTTApi\Service\Operation\ArrayWrapper
     */
    private $arrayWrapper;
    /**
     * @readonly
     * @var \Alamirault\FFTTApi\Service\NomPrenomExtractorInterface
     */
    private $nomPrenomExtractor;
    public function __construct(FFTTClientInterface $client, ArrayWrapper $arrayWrapper, NomPrenomExtractorInterface $nomPrenomExtractor)
    {
        $this->client = $client;
        $this->arrayWrapper = $arrayWrapper;
        $this->nomPrenomExtractor = $nomPrenomExtractor;
    }

    /**
     * @return array<Partie>
     */
    public function listPartiesJoueurByLicence(string $licenceId): array
    {
        /** @var array<mixed> $parties */
        $parties = $this->client->get('xml_partie_mysql', [
                'licence' => $licenceId,
            ])['partie'] ?? [];
        $parties = $this->arrayWrapper->wrapArrayIfUnique($parties);

        $res = [];

        /** @var array{advnompre: string, date: string, vd: string, numjourn: string, pointres: string, coefchamp: string, advlic: string, advsexe: string, advclaof: string} $partie */
        foreach ($parties as $partie) {
            [$nom, $prenom] = $this->nomPrenomExtractor->extractNomPrenom($partie['advnompre']);
            /** @var \DateTime $date */
            $date = \DateTime::createFromFormat('d/m/Y', $partie['date']);

            $realPartie = new Partie(
                'V' === $partie['vd'],
                (int) $partie['numjourn'],
                $date,
                (float) $partie['pointres'],
                (float) $partie['coefchamp'],
                $partie['advlic'],
                'M' === $partie['advsexe'],
                $nom,
                $prenom,
                (int) $partie['advclaof']
            );
            $res[] = $realPartie;
        }

        return $res;
    }

    /**
     * @return array<UnvalidatedPartie>
     */
    public function listUnvalidatedPartiesJoueurByLicence(string $joueurId): array
    {
        $validatedParties = $this->listPartiesJoueurByLicence($joueurId);

        /** @var array<array{victoire: string, forfait: string, nom: string, date: string, epreuve: string, idpartie: string, coefchamp: string, classement: string}> $allParties */
        $allParties = $this->client->get('xml_partie', [
                'numlic' => $joueurId,
            ])['partie'] ?? [];

        $result = [];
        foreach ($allParties as $partie) {
            if ('V' !== $partie['victoire'] || '1' !== $partie['forfait']) {
                [$nom, $prenom] = $this->nomPrenomExtractor->extractNomPrenom($partie['nom']);
                $found = count(array_filter($validatedParties, function ($validatedPartie) use ($partie, $nom, $prenom) {
                    return $partie['date'] === $validatedPartie->getDate()->format('d/m/Y')
                        and $this->removeAccentLowerCaseRegex($nom) === $this->removeAccentLowerCaseRegex($validatedPartie->getAdversaireNom())
                        and (
                            preg_match('/'.$this->removeAccentLowerCaseRegex($prenom).'.*/', $this->removeAccentLowerCaseRegex($validatedPartie->getAdversairePrenom())) or
                            strpos($this->removeAccentLowerCaseRegex($prenom), $this->removeAccentLowerCaseRegex($validatedPartie->getAdversairePrenom())) !== false
                        );
                }));

                /** @var \DateTime $date */
                $date = \DateTime::createFromFormat('d/m/Y', $partie['date']);

                if (!$found && 'Absent Absent' !== $prenom
                    && $this->isInCurrentSaison($date)
                    && $this->isInCurrentVirtualMonth($date)) {
                    /* @var DateTime $date */

                    $result[] = new UnvalidatedPartie(
                        $partie['epreuve'],
                        $partie['idpartie'],
                        (float) $partie['coefchamp'],
                        'V' === $partie['victoire'],
                        '1' === $partie['forfait'],
                        $date,
                        $nom,
                        $prenom,
                        (int) $this->formatPoints($partie['classement'])
                    );
                }
            }
        }

        return $result;
    }

    private function removeAccentLowerCaseRegex(string $string): string
    {
        /** @var \Transliterator $transliterator */
        $transliterator = \Transliterator::create('NFD; [:Nonspacing Mark:] Remove;');

        /** @var string $transliterated */
        $transliterated = $transliterator->transliterate($string);

        return str_replace('?', '.', mb_convert_case($transliterated, MB_CASE_LOWER, 'UTF-8'));
    }

    /**
     * Détermine si la date d'une rencontre passée en paramètre correspond à la saison en cours.
     */
    private function isInCurrentSaison(\DateTime $dateRencontre): bool
    {
        $today = new \DateTime();

        $actualMonth = (int) $today->format('n');
        $actualYear = (int) $today->format('Y');

        $dateDebutSaison = new \DateTime($actualYear + ($actualMonth >= 7 ? 0 : -1).'-07-01');
        $dateFinSaison = new \DateTime($actualYear + ($actualMonth >= 7 ? 1 : 0).'-07-01');

        return $dateRencontre >= $dateDebutSaison && $dateRencontre <= $dateFinSaison;
    }

    /**
     * Détermine si la date d'une rencontre passée en paramètre correspond au mois virtuel en cours, calculée du 1er [mois] inclus au 4 [mois+1] inclus
     * En d'autres termes, les rencontres virtuelles sont prises à partir du 1er du mois précédent jusqu'au 4 du mois en cours
     * Exemple : si nous sommes le 6 Octobre, nous prenons les rencontre du 1er Septembre à aujourd'hui.
     * Exemple : si nous sommes le 15 Octobre, nous prenons les rencontre du 1er Octobre (les points virtuels sont connus à partir du 5 et les rencontres sont comptabilisées du 1er au 31 du mois) à aujourd'hui.
     */
    private function isInCurrentVirtualMonth(\DateTime $dateRencontre): bool
    {
        $today = new \DateTime();

        $actualMonth = $today->format('n');
        $actualYear = $today->format('Y');

        if ($today->format('j') > self::JOUR_DEBUT_MOIS_VIRTUEL - 1) {
            $debutMoisVirtuel = $actualMonth;
        } else {
            if ($actualMonth > 1) {
                $debutMoisVirtuel = $actualMonth - 1;
            } else {
                $debutMoisVirtuel = 12;
                --$actualYear;
            }
        }

        $dateDebutMoisVirtuel = new \DateTime($actualYear.'-'.$debutMoisVirtuel.'-01');
        $dateFinMoisVirtuel = new \DateTime();

        return $dateRencontre >= $dateDebutMoisVirtuel && $dateRencontre <= $dateFinMoisVirtuel;
    }

    private function formatPoints(string $classement): string
    {
        $explode = explode('-', $classement);
        if (2 == count($explode)) {
            $classement = $explode[1];
        }

        return $classement;
    }
}
