<?php declare(strict_types=1);

namespace Alamirault\FFTTApi\Model;

final class Equipe
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
    private $division;
    /**
     * @readonly
     * @var string
     */
    private $lienDivision;
    public function __construct(string $libelle, string $division, string $lienDivision)
    {
        $this->libelle = $libelle;
        $this->division = $division;
        $this->lienDivision = $lienDivision;
    }
    public function getLibelle(): string
    {
        return $this->libelle;
    }

    public function getDivision(): string
    {
        return $this->division;
    }

    public function getLienDivision(): string
    {
        return $this->lienDivision;
    }
}
