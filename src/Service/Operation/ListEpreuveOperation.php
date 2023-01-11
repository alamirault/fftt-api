<?php declare(strict_types=1);

namespace Alamirault\FFTTApi\Service\Operation;

use Alamirault\FFTTApi\Model\Enums\TypeEpreuveEnum;
use Alamirault\FFTTApi\Model\Epreuve;
use Alamirault\FFTTApi\Service\FFTTClientInterface;

final class ListEpreuveOperation
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
     * @return array<Epreuve>
     */
    public function listEpreuves(int $organisme, TypeEpreuveEnum $type): array
    {
        /** @var array<array{idepreuve: string, idorga: string, libelle:string, typepreuve: string}> $epreuves */
        $epreuves = $this->client->get('xml_epreuve', [
            'type' => $type->value,
            'organisme' => (string) $organisme,
        ])['epreuve'];

        $result = [];
        foreach ($epreuves as $epreuve) {
            $result[] = new Epreuve(
                (int) $epreuve['idepreuve'],
                (int) $epreuve['idorga'],
                $epreuve['libelle'],
                $epreuve['typepreuve']
            );
        }

        return $result;
    }
}
