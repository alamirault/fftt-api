<?php declare(strict_types=1);

namespace Alamirault\FFTTApi\Service\Operation;

use Alamirault\FFTTApi\Exception\ClubNotFoundException;
use Alamirault\FFTTApi\Exception\InternalServerErrorException;
use Alamirault\FFTTApi\Exception\JoueurNotFoundException;
use Alamirault\FFTTApi\Model\Enums\NationaliteEnum;
use Alamirault\FFTTApi\Model\Enums\TypeLicenceEnum;
use Alamirault\FFTTApi\Model\JoueurDetails;
use Alamirault\FFTTApi\Service\FFTTClientInterface;

final class RetrieveJoueurDetailsOperation
{
    public const TYPE_HOMME = 'M';
    public const TYPE_CLASSE_NATIONAL = 'N';
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
     * Retrieve list of players searched by licenceId, filtered by a specific club with an optionnal clubId.
     *
     * @return JoueurDetails|array<JoueurDetails>
     *
     * @throws JoueurNotFoundException
     */
    public function retrieveJoueurDetails(string $licenceId, ?string $clubId = null)
    {
        $options = [
            'licence' => $licenceId,
        ];

        if (null !== $clubId) {
            $options['club'] = $clubId;
        }

        try {
            /** @var array<mixed> $data */
            $data = $this->client->get('xml_licence_b', $options);
        } catch (InternalServerErrorException $e) {
            if (null !== $clubId) {
                throw new ClubNotFoundException($clubId);
            }
            throw $e;
        }

        if (array_key_exists('licence', $data)) {
            $data = $data['licence'];
        } else {
            throw new JoueurNotFoundException($licenceId, $clubId);
        }

        if (is_array(array_values($data)[0])) { // Une liste de joueurs est retournée si le paramètre "licence" est vide et que "club" est renseigné et existe
            $listeJoueurs = [];
            foreach ($data as $joueur) {
                $listeJoueurs[] = $this->returnJoueurDetails($joueur);
            }

            return $listeJoueurs;
        } else {
            return $this->returnJoueurDetails($data);
        }
    }

    /**
     * @param array{idlicence: string, licence: string, sexe: string, point: ?string, nom: string, echelon: ?string, place: ?string, numclub: string, nomclub: string, natio: string, prenom: string, mutation: ?string, validation: ?string, type: ?string, initm: ?string, pointm: ?string, apointm: ?string, tech: ?string, arb: ?string, ja: ?string, cat: string } $joueurDetails
     */
    private function returnJoueurDetails(array $joueurDetails): JoueurDetails
    {
        return new JoueurDetails(
            (int) $joueurDetails['idlicence'],
            $joueurDetails['licence'],
            $joueurDetails['nom'],
            $joueurDetails['prenom'],
            $joueurDetails['type'] ? TypeLicenceEnum::from($joueurDetails['type']) : null,
            $joueurDetails['validation'] && \DateTime::createFromFormat('!d/m/Y', $joueurDetails['validation']) ? \DateTime::createFromFormat('!d/m/Y', $joueurDetails['validation']) : null,
            $joueurDetails['numclub'],
            $joueurDetails['nomclub'],
            self::TYPE_HOMME === $joueurDetails['sexe'],
            $joueurDetails['cat'],
            $joueurDetails['initm'] ? (float) $joueurDetails['initm'] : null,
            (float) $joueurDetails['point'],
            $joueurDetails['pointm'] ? (float) $joueurDetails['pointm'] : null,
            $joueurDetails['apointm'] ? (float) $joueurDetails['apointm'] : null,
            self::TYPE_CLASSE_NATIONAL === $joueurDetails['echelon'],
            $joueurDetails['place'] ? (int) $joueurDetails['place'] : null,
            NationaliteEnum::from($joueurDetails['natio']),
            $joueurDetails['mutation'] && \DateTime::createFromFormat('!d/m/Y', $joueurDetails['mutation']) ? \DateTime::createFromFormat('!d/m/Y', $joueurDetails['mutation']) : null,
            $joueurDetails['arb'] ?: null,
            $joueurDetails['ja'] ?: null,
            $joueurDetails['tech'] ?: null
        );
    }
}
