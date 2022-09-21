<?php declare(strict_types=1);

namespace Alamirault\FFTTApi\Model\Rencontre;

final class Partie
{
    /**
     * @readonly
     * @var string
     */
    private $adversaireA;
    /**
     * @readonly
     * @var string
     */
    private $adversaireB;
    /**
     * @readonly
     * @var int
     */
    private $scoreA;
    /**
     * @readonly
     * @var int
     */
    private $scoreB;
    /**
     * @var array<string>
     * @readonly
     */
    private $setDetails;
    /**
     * @param array<string> $setDetails
     */
    public function __construct(string $adversaireA, string $adversaireB, int $scoreA, int $scoreB, array $setDetails)
    {
        $this->adversaireA = $adversaireA;
        $this->adversaireB = $adversaireB;
        $this->scoreA = $scoreA;
        $this->scoreB = $scoreB;
        $this->setDetails = $setDetails;
    }
    public function getAdversaireA(): string
    {
        return $this->adversaireA;
    }

    public function getAdversaireB(): string
    {
        return $this->adversaireB;
    }

    public function getScoreA(): int
    {
        return $this->scoreA;
    }

    public function getScoreB(): int
    {
        return $this->scoreB;
    }

    /**
     * @return array<string>
     */
    public function getSetDetails(): array
    {
        return $this->setDetails;
    }
}
