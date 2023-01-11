<?php declare(strict_types=1);

namespace Alamirault\FFTTApi\Model;

final class Epreuve
{
    /**
     * @readonly
     * @var int
     */
    private $idEpreuve;
    /**
     * @readonly
     * @var int
     */
    private $idOrga;
    /**
     * @readonly
     * @var string
     */
    private $libelle;
    /**
     * @readonly
     * @var string
     */
    private $typeEpreuve;
    public function __construct(int $idEpreuve, int $idOrga, string $libelle, string $typeEpreuve)
    {
        $this->idEpreuve = $idEpreuve;
        $this->idOrga = $idOrga;
        $this->libelle = $libelle;
        $this->typeEpreuve = $typeEpreuve;
    }
    public function getIdEpreuve(): int
    {
        return $this->idEpreuve;
    }

    public function getIdOrga(): int
    {
        return $this->idOrga;
    }

    public function getLibelle(): string
    {
        return $this->libelle;
    }

    public function getTypeEpreuve(): string
    {
        return $this->typeEpreuve;
    }
}
