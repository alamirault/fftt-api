<?php declare(strict_types=1);

namespace Alamirault\FFTTApi\Service\Operation;

use Alamirault\FFTTApi\Model\Club;
use Alamirault\FFTTApi\Model\Factory\ClubFactory;
use Alamirault\FFTTApi\Service\FFTTClientInterface;
use Exception;

final class ListClubOperation
{
    /**
     * @readonly
     * @var \Alamirault\FFTTApi\Service\FFTTClientInterface
     */
    private $client;
    /**
     * @readonly
     * @var \Alamirault\FFTTApi\Model\Factory\ClubFactory
     */
    private $clubFactory;
    /**
     * @readonly
     * @var \Alamirault\FFTTApi\Service\Operation\ArrayWrapper
     */
    private $arrayWrapper;
    public function __construct(FFTTClientInterface $client, ClubFactory $clubFactory, ArrayWrapper $arrayWrapper)
    {
        $this->client = $client;
        $this->clubFactory = $clubFactory;
        $this->arrayWrapper = $arrayWrapper;
    }
    /**
     * @return array<Club>
     */
    public function listClubsByDepartement(int $departementId): array
    {
        /** @var array<array{numero: string, nom: string, validation: array<mixed>|string}> $rawClubs */
        $rawClubs = $this->client->get('xml_club_dep2', [
            'dep' => (string) $departementId,
        ])['club'];

        return $this->clubFactory->createFromArray($rawClubs);
    }

    /**
     * @return array<Club>
     */
    public function listClubsByName(string $name): array
    {
        try {
            /** @var array<mixed> $rawClubs */
            $rawClubs = $this->client->get('xml_club_b', [
                    'ville' => $name,
                ])['club'] ?? [];

            /** @var array<array{numero: string, nom: string, validation: array<mixed>|string}> $rawClubs */
            $rawClubs = $this->arrayWrapper->wrapArrayIfUnique($rawClubs);

            return $this->clubFactory->createFromArray($rawClubs);
        } catch (Exception $e) {
            return [];
        }
    }
}
