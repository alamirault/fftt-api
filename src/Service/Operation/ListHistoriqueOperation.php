<?php declare(strict_types=1);

namespace Alamirault\FFTTApi\Service\Operation;

use Alamirault\FFTTApi\Model\Historique;
use Alamirault\FFTTApi\Service\FFTTClientInterface;

final class ListHistoriqueOperation
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
     * @return array<Historique>
     */
    public function listHistorique(string $licenceId): array
    {
        /** @var array<mixed> $classements */
        $classements = $this->client->get('xml_histo_classement', [
                'numlic' => $licenceId,
            ])['histo'] ?? [];

        $classements = $this->arrayWrapper->wrapArrayIfUnique($classements);

        $result = [];
        /** @var array{saison: string, phase: string, point: string} $classement */
        foreach ($classements as $classement) {
            $explode = explode(' ', $classement['saison']);

            $historique = new Historique((int) $explode[1], (int) $explode[3], (int) $classement['phase'], (int) $classement['point']);
            $result[] = $historique;
        }

        return $result;
    }
}
