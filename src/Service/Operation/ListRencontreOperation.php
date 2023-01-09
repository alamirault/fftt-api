<?php declare(strict_types=1);

namespace Alamirault\FFTTApi\Service\Operation;

use Alamirault\FFTTApi\Model\Equipe;
use Alamirault\FFTTApi\Model\Rencontre\Rencontre;
use Alamirault\FFTTApi\Service\FFTTClientInterface;

final class ListRencontreOperation
{
    /**
     * @readonly
     * @var \Alamirault\FFTTApi\Service\FFTTClientInterface
     */
    private $client;
    public function __construct(FFTTClientInterface $client)
    {
        $this->client = $client;
    }
    /**
     * @return array<Rencontre>
     */
    public function listRencontrePouleByLienDivision(string $lienDivision): array
    {
        $data = $this->client->get('xml_result_equ', [], $lienDivision);

        $result = [];
        if (array_key_exists('tour', $data)) {
            /** @var array<array{equa: array<mixed>|string, equb: array<mixed>|string, dateprevue:string, datereelle: ?string, libelle: string, scorea: string, scoreb: string, lien: string }> $data */
            $data = $data['tour'];
            foreach ($data as $dataRencontre) {
                $equipeA = $dataRencontre['equa'];
                $equipeB = $dataRencontre['equb'];

                /** @var string $nomEquipeA */
                $nomEquipeA = is_array($equipeA) ? '' : $equipeA;

                /** @var string $nomEquipeB */
                $nomEquipeB = is_array($equipeB) ? '' : $equipeB;

                /** @var \DateTime $datePrevue */
                $datePrevue = \DateTime::createFromFormat('d/m/Y', $dataRencontre['dateprevue']);

                /** @var \DateTime|null $dateReelle */
                $dateReelle = empty($dataRencontre['datereelle']) ? null : \DateTime::createFromFormat('d/m/Y', $dataRencontre['datereelle']);

                $result[] = new Rencontre(
                    $dataRencontre['libelle'],
                    $nomEquipeA,
                    $nomEquipeB,
                    (int) $dataRencontre['scorea'],
                    (int) $dataRencontre['scoreb'],
                    $dataRencontre['lien'],
                    $datePrevue,
                    $dateReelle
                );
            }
        }

        return $result;
    }

    /**
     * @return array<Rencontre>
     */
    public function listProchainesRencontresEquipe(Equipe $equipe): array
    {
        $nomEquipe = $this->extractNomEquipe($equipe);
        $rencontres = $this->listRencontrePouleByLienDivision($equipe->getLienDivision());

        $prochainesRencontres = [];
        foreach ($rencontres as $rencontre) {
            if (null === $rencontre->getDateReelle() && ($rencontre->getNomEquipeA() === $nomEquipe || $rencontre->getNomEquipeB() === $nomEquipe)) {
                $prochainesRencontres[] = $rencontre;
            }
        }

        return $prochainesRencontres;
    }

    private function extractNomEquipe(Equipe $equipe): string
    {
        $explode = explode(' - ', $equipe->getLibelle());
        if (2 === count($explode)) {
            return $explode[0];
        }

        return $equipe->getLibelle();
    }
}
