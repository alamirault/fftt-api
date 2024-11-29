<?php declare(strict_types=1);

namespace Alamirault\FFTTApi\Service\Operation;

use Alamirault\FFTTApi\Exception\JoueurNotFoundException;
use Alamirault\FFTTApi\Model\Classement;
use Alamirault\FFTTApi\Service\FFTTClientInterface;

final class RetrieveClassementOperation
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
    public function retrieveClassement(string $licenceId): Classement
    {
        /** @var array<mixed> $joueurDetails */
        $joueurDetails = $this->client->get('xml_joueur', [
            'licence' => $licenceId,
        ])['joueur'] ?? [];

        if (false === array_key_exists('nom', $joueurDetails)) {
            throw new JoueurNotFoundException($licenceId);
        }

        $classement = new Classement(
            new \DateTime(),
            (float) $joueurDetails['point'],
            (float) $joueurDetails['apoint'],
            (int) $joueurDetails['clast'],
            (int) $joueurDetails['clnat'],
            (int) $joueurDetails['rangreg'],
            (int) $joueurDetails['rangdep'],
            (int) $joueurDetails['valcla'],
            (float) $joueurDetails['valinit']
        );

        return $classement;
    }
}
