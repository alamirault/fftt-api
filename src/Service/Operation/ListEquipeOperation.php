<?php declare(strict_types=1);

namespace Alamirault\FFTTApi\Service\Operation;

use Alamirault\FFTTApi\Model\Equipe;
use Alamirault\FFTTApi\Service\FFTTClientInterface;

final class ListEquipeOperation
{
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
    public function __construct(FFTTClientInterface $client, ArrayWrapper $arrayWrapper)
    {
        $this->client = $client;
        $this->arrayWrapper = $arrayWrapper;
    }
    /**
     * @return array<Equipe>
     */
    public function listEquipesByClub(string $clubId, string $type = null): array
    {
        $params = [
            'numclu' => $clubId,
        ];

        if ($type) {
            $params['type'] = $type;
        }

        /** @var array<mixed>|null $data */
        $data = $this->client->get('xml_equipe', $params
        )['equipe'] ?? null;

        if (null === $data) {
            return [];
        }

        $data = $this->arrayWrapper->wrapArrayIfUnique($data);

        $result = [];
        /** @var array{libequipe: string, libdivision: string, liendivision: string} $dataEquipe */
        foreach ($data as $dataEquipe) {
            $result[] = new Equipe(
                $dataEquipe['libequipe'],
                $dataEquipe['libdivision'],
                $dataEquipe['liendivision']
            );
        }

        return $result;
    }
}
