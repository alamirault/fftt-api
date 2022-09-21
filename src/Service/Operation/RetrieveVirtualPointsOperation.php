<?php declare(strict_types=1);

namespace Alamirault\FFTTApi\Service\Operation;

use Alamirault\FFTTApi\Exception\InvalidRequestException;
use Alamirault\FFTTApi\Exception\InvalidResponseException;
use Alamirault\FFTTApi\Exception\JoueurNotFoundException;
use Alamirault\FFTTApi\Model\UnvalidatedPartie;
use Alamirault\FFTTApi\Model\VirtualPoints;
use Alamirault\FFTTApi\Service\PointCalculator;

final class RetrieveVirtualPointsOperation
{
    private const JOUR_DEBUT_MOIS_VIRTUEL = 5;
    /**
     * @readonly
     * @var \Alamirault\FFTTApi\Service\Operation\RetrieveClassementOperation
     */
    private $retrieveClassementOperation;
    /**
     * @readonly
     * @var \Alamirault\FFTTApi\Service\Operation\ListPartieOperation
     */
    private $listPartieOperation;
    /**
     * @readonly
     * @var \Alamirault\FFTTApi\Service\Operation\ListJoueurOperation
     */
    private $listJoueurOperation;
    /**
     * @readonly
     * @var \Alamirault\FFTTApi\Service\PointCalculator
     */
    private $pointCalculator;
    public function __construct(RetrieveClassementOperation $retrieveClassementOperation, ListPartieOperation $listPartieOperation, ListJoueurOperation $listJoueurOperation, PointCalculator $pointCalculator)
    {
        $this->retrieveClassementOperation = $retrieveClassementOperation;
        $this->listPartieOperation = $listPartieOperation;
        $this->listJoueurOperation = $listJoueurOperation;
        $this->pointCalculator = $pointCalculator;
    }

    /**
     * @return VirtualPoints Objet contenant les points gagnés/perdus et le classement virtuel du joueur
     */
    public function retrieveVirtualPoints(string $licenceId): VirtualPoints
    {
        try {
            $classement = $this->retrieveClassementOperation->retrieveClassement($licenceId);
            $virtualMonthlyPointsWon = 0.0;
            $latestMonth = null;
            $monthPoints = round($classement->getPoints(), 1);

            $unvalidatedParties = $this->listPartieOperation->listUnvalidatedPartiesJoueurByLicence($licenceId);

            usort($unvalidatedParties, function (UnvalidatedPartie $a, UnvalidatedPartie $b) {
                return ($a->getDate() >= $b->getDate()) ? 1 : 0;
            });

            foreach ($unvalidatedParties as $unvalidatedParty) {
                if (!$latestMonth) {
                    $latestMonth = $unvalidatedParty->getDate()->format('m');
                } else {
                    if ($latestMonth != $unvalidatedParty->getDate()->format('m') && $unvalidatedParty->getDate()->format('j') > self::JOUR_DEBUT_MOIS_VIRTUEL - 1) {
                        $monthPoints = round($classement->getPoints() + $virtualMonthlyPointsWon, 1);
                        $latestMonth = $unvalidatedParty->getDate()->format('m');
                    }
                }

                $coeff = $unvalidatedParty->getCoefficientChampionnat();

                if (!$unvalidatedParty->isForfait()) {
                    $adversairePoints = $unvalidatedParty->getAdversaireClassement();

                    /*
                     * TODO Refactoring in method
                     */

                    try {
                        $availableJoueurs = $this->listJoueurOperation->listJoueursByNom($unvalidatedParty->getAdversaireNom(), $unvalidatedParty->getAdversairePrenom());
                        foreach ($availableJoueurs as $availableJoueur) {
                            if (round($unvalidatedParty->getAdversaireClassement() / 100) == $availableJoueur->getPoints()) {
                                $classementJoueur = $this->retrieveClassementOperation->retrieveClassement($availableJoueur->getLicence());
                                $adversairePoints = round($classementJoueur->getPoints(), 1);
                                break;
                            }
                        }
                    } catch (InvalidResponseException|InvalidRequestException $exception) {
                        $adversairePoints = $unvalidatedParty->getAdversaireClassement();
                    }

                    $points = $unvalidatedParty->isVictoire()
                        ? $this->pointCalculator->getPointVictory($monthPoints, floatval($adversairePoints))
                        : $this->pointCalculator->getPointDefeat($monthPoints, floatval($adversairePoints));
                    $virtualMonthlyPointsWon += $points * $coeff;
                }
            }

            $virtualMonthlyPoints = $monthPoints + $virtualMonthlyPointsWon;

            return new VirtualPoints(
                $virtualMonthlyPointsWon,
                $virtualMonthlyPoints,
                $virtualMonthlyPoints - $classement->getPointsInitials()
            );
        } catch (JoueurNotFoundException $e) {
            return new VirtualPoints(0.0, 0.0, 0.0);
        }
    }
}
