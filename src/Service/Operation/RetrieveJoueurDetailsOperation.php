<?php declare(strict_types=1);

namespace Alamirault\FFTTApi\Service\Operation;

use Alamirault\FFTTApi\Exception\JoueurNotFoundException;
use Alamirault\FFTTApi\Model\JoueurDetails;
use Alamirault\FFTTApi\Service\FFTTClientInterface;

final class RetrieveJoueurDetailsOperation
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
    public function retrieveJoueurDetails(string $licenceId): JoueurDetails
    {
        /** @var array<mixed> $data */
        $data = $this->client->get('xml_licence_b', [
                'licence' => $licenceId,
            ]
        )['licence'] ?? [];

        if (false === array_key_exists('nom', $data)) {
            throw new JoueurNotFoundException($licenceId);
        }

        $joueurDetails = new JoueurDetails(
            $licenceId,
            $data['nom'],
            $data['prenom'],
            $data['numclub'],
            $data['nomclub'],
            'M' === $data['sexe'] ? true : false,
            $data['cat'],
            (float) ($data['initm'] ?? (float) $data['point']),
            (float) $data['point'],
            (float) ($data['pointm'] ?? (float) $data['point']),
            (float) ($data['apointm'] ?? (float) $data['point'])
        );

        return $joueurDetails;
    }
}
