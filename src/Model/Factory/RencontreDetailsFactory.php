<?php declare(strict_types=1);

namespace Alamirault\FFTTApi\Model\Factory;

use Accentuation\Accentuation;
use Alamirault\FFTTApi\Model\Rencontre\Joueur;
use Alamirault\FFTTApi\Model\Rencontre\Partie;
use Alamirault\FFTTApi\Model\Rencontre\RencontreDetails;
use Alamirault\FFTTApi\Service\NomPrenomExtractorInterface;
use Alamirault\FFTTApi\Service\Operation\ListJoueurOperation;

/**
 * @phpstan-type RawJoueur array<array{xja: string|null, xjb: string|null,xca: string|null,xcb: string|null}>
 * @phpstan-type RawResultat array{resa: array<mixed>|string, resb: array<mixed>|string, equa: string, equb: string}
 * @phpstan-type RawPartie array<array{detail: string, ja: array<mixed>|string, jb: array<mixed>|string, scorea: string, scoreb: string}>
 */
final class RencontreDetailsFactory
{
    /**
     * @readonly
     * @var \Alamirault\FFTTApi\Service\NomPrenomExtractorInterface
     */
    private $nomPrenomExtractor;
    /**
     * @readonly
     * @var \Alamirault\FFTTApi\Service\Operation\ListJoueurOperation
     */
    private $listJoueurOperation;
    public function __construct(NomPrenomExtractorInterface $nomPrenomExtractor, ListJoueurOperation $listJoueurOperation)
    {
        $this->nomPrenomExtractor = $nomPrenomExtractor;
        $this->listJoueurOperation = $listJoueurOperation;
    }
    /**
     * @param array{joueur: RawJoueur, resultat: RawResultat, partie: RawPartie} $array
     */
    public function createFromArray(array $array, string $clubEquipeA, string $clubEquipeB): RencontreDetails
    {
        $joueursA = [];
        $joueursB = [];
        foreach ($array['joueur'] as $joueur) {
            $joueursA[] = [$joueur['xja'] ?: '', $joueur['xca'] ?: ''];
            $joueursB[] = [$joueur['xjb'] ?: '', $joueur['xcb'] ?: ''];
        }
        $joueursAFormatted = $this->formatJoueurs($joueursA, $clubEquipeA);
        $joueursBFormatted = $this->formatJoueurs($joueursB, $clubEquipeB);

        $parties = $this->getParties($array['partie']);

        if (is_array($array['resultat']['resa'])) {
            $scores = $this->getScores($parties);
            $scoreA = $scores['scoreA'];
            $scoreB = $scores['scoreB'];
        } else {
            $scoreA = 'F0' === $array['resultat']['resa'] ? 0 : $array['resultat']['resa'];
            $scoreB = 'F0' === $array['resultat']['resb'] ? 0 : $array['resultat']['resb'];
        }

        $expected = $this->getExpectedPoints($parties, $joueursAFormatted, $joueursBFormatted);

        return new RencontreDetails(
            $array['resultat']['equa'],
            $array['resultat']['equb'],
            (int) $scoreA,
            (int) $scoreB,
            $joueursAFormatted,
            $joueursBFormatted,
            $parties,
            $expected['expectedA'],
            $expected['expectedB']
        );
    }

    /**
     * @param array<Partie>         $parties
     * @param array<string, Joueur> $joueursAFormatted
     * @param array<string, Joueur> $joueursBFormatted
     *
     * @return array{expectedA: float, expectedB: float}
     */
    private function getExpectedPoints(array $parties, array $joueursAFormatted, array $joueursBFormatted): array
    {
        $expectedA = 0;
        $expectedB = 0;

        foreach ($parties as $partie) {
            $adversaireA = $partie->getAdversaireA();
            $adversaireB = $partie->getAdversaireB();

            if (isset($joueursAFormatted[$adversaireA])) {
                $joueurA = $joueursAFormatted[$adversaireA];
                $joueurAPoints = $joueurA->getPoints();
            } else {
                $joueurAPoints = 'NONE';
            }

            if (isset($joueursBFormatted[$adversaireB])) {
                $joueurB = $joueursBFormatted[$adversaireB];
                $joueurBPoints = $joueurB->getPoints();
            } else {
                $joueurBPoints = 'NONE';
            }

            if ($joueurAPoints === $joueurBPoints) {
                $expectedA += 0.5;
                $expectedB += 0.5;
            } elseif ($joueurAPoints > $joueurBPoints) {
                ++$expectedA;
            } else {
                ++$expectedB;
            }
        }

        return [
            'expectedA' => $expectedA,
            'expectedB' => $expectedB,
        ];
    }

    /**
     * @param array<Partie> $parties
     *
     * @return array{scoreA: int, scoreB: int}
     */
    private function getScores(array $parties): array
    {
        $scoreA = 0;
        $scoreB = 0;

        foreach ($parties as $partie) {
            $scoreA += $partie->getScoreA();
            $scoreB += $partie->getScoreB();
        }

        return [
            'scoreA' => $scoreA,
            'scoreB' => $scoreB,
        ];
    }

    /**
     * @param array<array{0: string, 1: string}> $data
     *
     * @return array<string, Joueur>
     */
    private function formatJoueurs(array $data, string $playerClubId): array
    {
        $joueursClub = $this->listJoueurOperation->listJoueursByClub($playerClubId);

        $joueurs = [];
        foreach ($data as $joueurData) {
            $nomPrenom = $joueurData[0];
            [$nom, $prenom] = $this->nomPrenomExtractor->extractNomPrenom($nomPrenom);
            $joueurs[$this->nomPrenomExtractor->removeSeparatorsDuplication($nomPrenom)] = $this->formatJoueur($prenom, $nom, $joueurData[1], $joueursClub);
        }

        return $joueurs;
    }

    /**
     * @param array<\Alamirault\FFTTApi\Model\Joueur> $joueursClub
     */
    private function formatJoueur(string $prenom, string $nom, string $points, array $joueursClub): Joueur
    {
        if ('' === $nom && 'Absent' === $prenom) {
            return new Joueur($nom, $prenom, '', null, null);
        }

        foreach ($joueursClub as $joueurClub) {
            $nomJoueurClub = $this->nomPrenomExtractor->removeSeparatorsDuplication($joueurClub->getNom());
            $prenomJoueurClub = $this->nomPrenomExtractor->removeSeparatorsDuplication($joueurClub->getPrenom());
            if ($nomJoueurClub === Accentuation::remove($nom) && $prenomJoueurClub === $prenom) {
                $return = preg_match('/^(N°[0-9]*- ){0,1}(?<sexe>[A-Z]{1}) (?<points>[0-9]+)pts$/', $points, $result);

                if (false === $return) {
                    throw new \RuntimeException(sprintf("Not able to extract sexe and points in '%s'", $points));
                }
                /** @var array{sexe: string|null, points: string|null} $result */
                $sexe = $result['sexe'];
                $playerPoints = $result['points'];

                return new Joueur(
                    $nomJoueurClub,
                    $prenomJoueurClub,
                    $joueurClub->getLicence(),
                    (int) $playerPoints,
                    $sexe
                );
            }
        }

        return new Joueur($nom, $prenom, '', null, null);
    }

    /**
     * @param RawPartie $data
     *
     * @return array<Partie>
     */
    private function getParties(array $data): array
    {
        $parties = [];
        foreach ($data as $partieData) {
            $setDetails = explode(' ', $partieData['detail']);

            /** @var string $adverssaireA */
            $adverssaireA = is_array($partieData['ja']) ? 'Absent Absent' : $this->nomPrenomExtractor->removeSeparatorsDuplication($partieData['ja']);

            /** @var string $adverssaireB */
            $adverssaireB = is_array($partieData['jb']) ? 'Absent Absent' : $this->nomPrenomExtractor->removeSeparatorsDuplication($partieData['jb']);

            $parties[] = new Partie(
                $adverssaireA,
                $adverssaireB,
                '-' === $partieData['scorea'] ? 0 : (int) $partieData['scorea'],
                '-' === $partieData['scoreb'] ? 0 : (int) $partieData['scoreb'],
                $setDetails
            );
        }

        return $parties;
    }
}
