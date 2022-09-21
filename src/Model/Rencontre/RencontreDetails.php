<?php declare(strict_types=1);

namespace Alamirault\FFTTApi\Model\Rencontre;

final class RencontreDetails
{
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
     * @var array<Joueur>
     * @readonly
     */
    private $joueursA;
    /**
     * @var array<Joueur>
     * @readonly
     */
    private $joueursB;
    /**
     * @var array<Partie>
     * @readonly
     */
    private $parties;
    /**
     * @readonly
     * @var float
     */
    private $expectedScoreEquipeA;
    /**
     * @readonly
     * @var float
     */
    private $expectedScoreEquipeB;
    /**
     * @param array<Joueur> $joueursA
     * @param array<Joueur> $joueursB
     * @param array<Partie> $parties
     */
    public function __construct(string $nomEquipeA, string $nomEquipeB, int $scoreEquipeA, int $scoreEquipeB, array $joueursA, array $joueursB, array $parties, float $expectedScoreEquipeA, float $expectedScoreEquipeB)
    {
        $this->nomEquipeA = $nomEquipeA;
        $this->nomEquipeB = $nomEquipeB;
        $this->scoreEquipeA = $scoreEquipeA;
        $this->scoreEquipeB = $scoreEquipeB;
        $this->joueursA = $joueursA;
        $this->joueursB = $joueursB;
        $this->parties = $parties;
        $this->expectedScoreEquipeA = $expectedScoreEquipeA;
        $this->expectedScoreEquipeB = $expectedScoreEquipeB;
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

    /**
     * @return array<Joueur>
     */
    public function getJoueursA(): array
    {
        return $this->joueursA;
    }

    /**
     * @return array<Joueur>
     */
    public function getJoueursB(): array
    {
        return $this->joueursB;
    }

    /**
     * @return array<Partie>
     */
    public function getParties(): array
    {
        return $this->parties;
    }

    public function getExpectedScoreEquipeA(): float
    {
        return $this->expectedScoreEquipeA;
    }

    public function getExpectedScoreEquipeB(): float
    {
        return $this->expectedScoreEquipeB;
    }
}
