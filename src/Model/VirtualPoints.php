<?php declare(strict_types=1);

namespace Alamirault\FFTTApi\Model;

class VirtualPoints
{
    /**
     * @readonly
     * @var float
     */
    private $monthlyPointsWon;
    /**
     * @readonly
     * @var float
     */
    private $virtualPoints;
    /**
     * @readonly
     * @var float
     */
    private $seasonlyPointsWon;
    public function __construct(float $monthlyPointsWon, float $virtualPoints, float $seasonlyPointsWon)
    {
        $this->monthlyPointsWon = $monthlyPointsWon;
        $this->virtualPoints = $virtualPoints;
        $this->seasonlyPointsWon = $seasonlyPointsWon;
    }
    public function getMonthlyPointsWon(): float
    {
        return $this->monthlyPointsWon;
    }

    public function getVirtualPoints(): float
    {
        return $this->virtualPoints;
    }

    public function getSeasonlyPointsWon(): float
    {
        return $this->seasonlyPointsWon;
    }
}
