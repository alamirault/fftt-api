<?php declare(strict_types=1);

namespace Alamirault\FFTTApi\Model;

use DateTime;

final class Club
{
    /**
     * @readonly
     * @var string
     */
    private $numero;
    /**
     * @readonly
     * @var string
     */
    private $nom;
    /**
     * @readonly
     * @var \DateTime|null
     */
    private $dateValidation;
    public function __construct(string $numero, string $nom, ?DateTime $dateValidation)
    {
        $this->numero = $numero;
        $this->nom = $nom;
        $this->dateValidation = $dateValidation;
    }
    public function getNumero(): string
    {
        return $this->numero;
    }

    public function getNom(): string
    {
        return $this->nom;
    }

    public function getDateValidation(): ?DateTime
    {
        return $this->dateValidation;
    }
}
