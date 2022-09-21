<?php declare(strict_types=1);

namespace Alamirault\FFTTApi\Service\Operation;

use Alamirault\FFTTApi\Model\Actualite;
use Alamirault\FFTTApi\Service\FFTTClientInterface;
use DateTime;

final class ListActualiteOperation
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
     * @return array<Actualite>
     */
    public function listActualites(): array
    {
        /** @var array<mixed> $data */
        $data = $this->client->get('xml_new_actu')['news'];
        $data = $this->arrayWrapper->wrapArrayIfUnique($data);

        $result = [];
        /** @var array{date: string, titre: string, description: string, url: string, photo: string, categorie: string} $dataActualite */
        foreach ($data as $dataActualite) {
            /** @var DateTime $date */
            $date = DateTime::createFromFormat('Y-m-d', $dataActualite['date']);
            $result[] = new Actualite(
                $date,
                $dataActualite['titre'],
                $dataActualite['description'],
                $dataActualite['url'],
                $dataActualite['photo'],
                $dataActualite['categorie']
            );
        }

        return $result;
    }
}
