<?php declare(strict_types=1);

namespace Alamirault\FFTTApi\Model;

final class Organisme
{
    /**
     * @readonly
     * @var string
     */
    private $libelle;
    /**
     * @readonly
     * @var int
     */
    private $id;
    /**
     * @readonly
     * @var string
     */
    private $code;
    /**
     * @readonly
     * @var int
     */
    private $idPere;
    public function __construct(string $libelle, int $id, string $code, int $idPere)
    {
        $this->libelle = $libelle;
        $this->id = $id;
        $this->code = $code;
        $this->idPere = $idPere;
    }
    public function getLibelle(): string
    {
        return $this->libelle;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getIdPere(): int
    {
        return $this->idPere;
    }
}
