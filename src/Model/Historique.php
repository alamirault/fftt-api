<?php declare(strict_types=1);

namespace Alamirault\FFTTApi\Model;

final class Historique
{
    /**
     * @readonly
     * @var int
     */
    private $anneeDebut;
    /**
     * @readonly
     * @var int
     */
    private $anneeFin;
    /**
     * @readonly
     * @var int
     */
    private $phase;
    /**
     * @readonly
     * @var int
     */
    private $points;
    public function __construct(int $anneeDebut, int $anneeFin, int $phase, int $points)
    {
        $this->anneeDebut = $anneeDebut;
        $this->anneeFin = $anneeFin;
        $this->phase = $phase;
        $this->points = $points;
    }
    public function getAnneeDebut(): int
    {
        return $this->anneeDebut;
    }

    public function getAnneeFin(): int
    {
        return $this->anneeFin;
    }

    public function getPhase(): int
    {
        return $this->phase;
    }

    public function getPoints(): int
    {
        return $this->points;
    }
}
