<?php declare(strict_types=1);

namespace Alamirault\FFTTApi\Model;

final class Classement
{
    /**
     * @readonly
     * @var \DateTime|null
     */
    private $date;
    /**
     * @readonly
     * @var float
     */
    private $points;
    /**
     * @readonly
     * @var float|null
     */
    private $anciensPoints;
    /**
     * @readonly
     * @var int
     */
    private $classement;
    /**
     * @readonly
     * @var int|null
     */
    private $rangNational;
    /**
     * @readonly
     * @var int|null
     */
    private $rangRegional;
    /**
     * @readonly
     * @var int|null
     */
    private $rangDepartemental;
    /**
     * @readonly
     * @var int|null
     */
    private $pointsOfficiels;
    /**
     * @readonly
     * @var float|null
     */
    private $pointsInitials;
    public function __construct(?\DateTime $date, float $points, ?float $anciensPoints, int $classement, ?int $rangNational, ?int $rangRegional, ?int $rangDepartemental, ?int $pointsOfficiels, ?float $pointsInitials)
    {
        $this->date = $date;
        $this->points = $points;
        $this->anciensPoints = $anciensPoints;
        $this->classement = $classement;
        $this->rangNational = $rangNational;
        $this->rangRegional = $rangRegional;
        $this->rangDepartemental = $rangDepartemental;
        $this->pointsOfficiels = $pointsOfficiels;
        $this->pointsInitials = $pointsInitials;
    }
    public function getDate(): ?\DateTime
    {
        return $this->date;
    }

    public function getPoints(): float
    {
        return $this->points;
    }

    public function getAnciensPoints(): ?float
    {
        return $this->anciensPoints;
    }

    public function getClassement(): int
    {
        return $this->classement;
    }

    public function getRangNational(): ?int
    {
        return $this->rangNational;
    }

    public function getRangRegional(): ?int
    {
        return $this->rangRegional;
    }

    public function getRangDepartemental(): ?int
    {
        return $this->rangDepartemental;
    }

    public function getPointsOfficiels(): ?int
    {
        return $this->pointsOfficiels;
    }

    public function getPointsInitials(): ?float
    {
        return $this->pointsInitials;
    }
}
