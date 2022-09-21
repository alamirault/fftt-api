<?php declare(strict_types=1);

namespace Alamirault\FFTTApi\Service\Operation;

use Alamirault\FFTTApi\Exception\ClubNotFoundException;
use Alamirault\FFTTApi\Model\ClubDetails;
use Alamirault\FFTTApi\Model\Equipe;
use Alamirault\FFTTApi\Service\FFTTClientInterface;

final class RetrieveClubDetailsOperation
{
    /**
     * @readonly
     * @var \Alamirault\FFTTApi\Service\FFTTClientInterface
     */
    private $client;
    /**
     * @readonly
     * @var \Alamirault\FFTTApi\Service\Operation\ListClubOperation
     */
    private $listClubOperation;
    public function __construct(FFTTClientInterface $client, ListClubOperation $listClubOperation)
    {
        $this->client = $client;
        $this->listClubOperation = $listClubOperation;
    }
    public function retrieveClubDetails(string $clubId): ClubDetails
    {
        /** @var array<mixed> $clubData */
        $clubData = $this->client->get('xml_club_detail', [
                'club' => $clubId,
            ])['club'] ?? [];

        if (false === array_key_exists('numero', $clubData)) {
            throw new ClubNotFoundException($clubId);
        }

        return new ClubDetails(
            (int) $clubData['numero'],
            $clubData['nom'],
            is_array($clubData['nomsalle']) ? null : $clubData['nomsalle'],
            is_array($clubData['adressesalle1']) ? null : $clubData['adressesalle1'],
            is_array($clubData['adressesalle2']) ? null : $clubData['adressesalle2'],
            is_array($clubData['adressesalle3']) ? null : $clubData['adressesalle3'],
            is_array($clubData['codepsalle']) ? null : $clubData['codepsalle'],
            is_array($clubData['villesalle']) ? null : $clubData['villesalle'],
            is_array($clubData['web']) ? null : $clubData['web'],
            is_array($clubData['nomcor']) ? null : $clubData['nomcor'],
            is_array($clubData['prenomcor']) ? null : $clubData['prenomcor'],
            is_array($clubData['mailcor']) ? null : $clubData['mailcor'],
            is_array($clubData['telcor']) ? null : $clubData['telcor'],
            is_array($clubData['latitude']) ? null : (float) $clubData['latitude'],
            is_array($clubData['longitude']) ? null : (float) $clubData['longitude']
        );
    }

    public function retrieveClubDetailsByEquipe(Equipe $equipe): ?ClubDetails
    {
        $nomEquipe = $this->extractClub($equipe);
        $club = $this->listClubOperation->listClubsByVille($nomEquipe);

        if (1 === count($club)) {
            return $this->retrieveClubDetails($club[0]->getNumero());
        }

        return null;
    }

    private function extractClub(Equipe $equipe): string
    {
        $nomEquipe = $this->extractNomEquipe($equipe);

        /** @var string $nomClub */
        $nomClub = preg_replace('/ [0-9]+$/', '', $nomEquipe);

        return $nomClub;
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
