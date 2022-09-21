<?php declare(strict_types=1);

namespace Alamirault\FFTTApi\Service\Operation;

use Alamirault\FFTTApi\Exception\InvalidLienRencontreException;
use Alamirault\FFTTApi\Model\Factory\RencontreDetailsFactory;
use Alamirault\FFTTApi\Model\Rencontre\RencontreDetails;
use Alamirault\FFTTApi\Service\FFTTClientInterface;

final class RetrieveRencontreDetailsOperation
{
    /**
     * @readonly
     * @var \Alamirault\FFTTApi\Service\FFTTClientInterface
     */
    private $client;
    /**
     * @readonly
     * @var \Alamirault\FFTTApi\Model\Factory\RencontreDetailsFactory
     */
    private $rencontreDetailsFactory;
    public function __construct(FFTTClientInterface $client, RencontreDetailsFactory $rencontreDetailsFactory)
    {
        $this->client = $client;
        $this->rencontreDetailsFactory = $rencontreDetailsFactory;
    }
    public function retrieveRencontreDetailsByLien(string $lienRencontre, string $clubEquipeA = '', string $clubEquipeB = ''): RencontreDetails
    {
        $data = $this->client->get('xml_chp_renc', [], $lienRencontre);
        if (!(isset($data['resultat']) && isset($data['joueur']) && isset($data['partie']))) {
            throw new InvalidLienRencontreException($lienRencontre);
        }

        return $this->rencontreDetailsFactory->createFromArray($data, $clubEquipeA, $clubEquipeB);
    }
}
