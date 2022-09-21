<?php declare(strict_types=1);

namespace Alamirault\FFTTApi\Model;

final class Partie
{
    /**
     * @readonly
     * @var bool
     */
    private $isVictoire;
    /**
     * @readonly
     * @var int
     */
    private $journee;
    /**
     * @readonly
     * @var \DateTime
     */
    private $date;
    /**
     * @readonly
     * @var float
     */
    private $pointsObtenus;
    /**
     * @readonly
     * @var float
     */
    private $coefficient;
    /**
     * @readonly
     * @var string
     */
    private $adversaireLicence;
    /**
     * @readonly
     * @var bool
     */
    private $adversaireIsHomme;
    /**
     * @readonly
     * @var string
     */
    private $adversaireNom;
    /**
     * @readonly
     * @var string
     */
    private $adversairePrenom;
    /**
     * @readonly
     * @var int
     */
    private $adversaireClassement;
    public function __construct(bool $isVictoire, int $journee, \DateTime $date, float $pointsObtenus, float $coefficient, string $adversaireLicence, bool $adversaireIsHomme, string $adversaireNom, string $adversairePrenom, int $adversaireClassement)
    {
        $this->isVictoire = $isVictoire;
        $this->journee = $journee;
        $this->date = $date;
        $this->pointsObtenus = $pointsObtenus;
        $this->coefficient = $coefficient;
        $this->adversaireLicence = $adversaireLicence;
        $this->adversaireIsHomme = $adversaireIsHomme;
        $this->adversaireNom = $adversaireNom;
        $this->adversairePrenom = $adversairePrenom;
        $this->adversaireClassement = $adversaireClassement;
    }
    public function isVictoire(): bool
    {
        return $this->isVictoire;
    }

    public function getJournee(): int
    {
        return $this->journee;
    }

    public function getDate(): \DateTime
    {
        return $this->date;
    }

    public function getPointsObtenus(): float
    {
        return $this->pointsObtenus;
    }

    public function getCoefficient(): float
    {
        return $this->coefficient;
    }

    public function getAdversaireLicence(): string
    {
        return $this->adversaireLicence;
    }

    public function isAdversaireIsHomme(): bool
    {
        return $this->adversaireIsHomme;
    }

    public function getAdversaireNom(): string
    {
        return $this->adversaireNom;
    }

    public function getAdversairePrenom(): string
    {
        return $this->adversairePrenom;
    }

    public function getAdversaireClassement(): int
    {
        return $this->adversaireClassement;
    }
}
