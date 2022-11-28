<?php declare(strict_types=1);

namespace Alamirault\FFTTApi\Model\Rencontre;

final class Rencontre
{
    /**
     * @readonly
     * @var string
     */
    private $libelle;
    /**
     * @readonly
     * @var string
     */
    private $nomEquipeA;
    /**
     * @readonly
     * @var string
     */
    private $nomEquipeB;
    /**
     * @readonly
     * @var int
     */
    private $scoreEquipeA;
    /**
     * @readonly
     * @var int
     */
    private $scoreEquipeB;
    /**
     * @readonly
     * @var string
     */
    private $lien;
    /**
     * @readonly
     * @var \DateTime
     */
    private $datePrevue;
    /**
     * @readonly
     * @var \DateTime|null
     */
    private $dateReelle;
    public function __construct(string $libelle, string $nomEquipeA, string $nomEquipeB, int $scoreEquipeA, int $scoreEquipeB, string $lien, \DateTime $datePrevue, ?\DateTime $dateReelle)
    {
        $this->libelle = $libelle;
        $this->nomEquipeA = $nomEquipeA;
        $this->nomEquipeB = $nomEquipeB;
        $this->scoreEquipeA = $scoreEquipeA;
        $this->scoreEquipeB = $scoreEquipeB;
        $this->lien = $lien;
        $this->datePrevue = $datePrevue;
        $this->dateReelle = $dateReelle;
    }
    public function getLibelle(): string
    {
        return $this->libelle;
    }

    public function getNomEquipeA(): string
    {
        return $this->nomEquipeA;
    }

    public function getNomEquipeB(): string
    {
        return $this->nomEquipeB;
    }

    public function getScoreEquipeA(): int
    {
        return $this->scoreEquipeA;
    }

    public function getScoreEquipeB(): int
    {
        return $this->scoreEquipeB;
    }

    public function getLien(): string
    {
        return $this->lien;
    }

    public function getDatePrevue(): \DateTime
    {
        return $this->datePrevue;
    }

    public function getDateReelle(): ?\DateTime
    {
        return $this->dateReelle;
    }
}
