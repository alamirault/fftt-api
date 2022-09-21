<?php declare(strict_types=1);

namespace Alamirault\FFTTApi\Model;

final class ClubDetails
{
    /**
     * @readonly
     * @var int
     */
    private $numero;
    /**
     * @readonly
     * @var string
     */
    private $nom;
    /**
     * @readonly
     * @var string|null
     */
    private $nomSalle;
    /**
     * @readonly
     * @var string|null
     */
    private $adresseSalle1;
    /**
     * @readonly
     * @var string|null
     */
    private $adresseSalle2;
    /**
     * @readonly
     * @var string|null
     */
    private $adresseSalle3;
    /**
     * @readonly
     * @var string|null
     */
    private $codePostaleSalle;
    /**
     * @readonly
     * @var string|null
     */
    private $villeSalle;
    /**
     * @readonly
     * @var string|null
     */
    private $siteWeb;
    /**
     * @readonly
     * @var string|null
     */
    private $nomCoordo;
    /**
     * @readonly
     * @var string|null
     */
    private $prenomCoordo;
    /**
     * @readonly
     * @var string|null
     */
    private $mailCoordo;
    /**
     * @readonly
     * @var string|null
     */
    private $telCoordo;
    /**
     * @readonly
     * @var float|null
     */
    private $latitude;
    /**
     * @readonly
     * @var float|null
     */
    private $longitude;
    public function __construct(int $numero, string $nom, ?string $nomSalle, ?string $adresseSalle1, ?string $adresseSalle2, ?string $adresseSalle3, ?string $codePostaleSalle, ?string $villeSalle, ?string $siteWeb, ?string $nomCoordo, ?string $prenomCoordo, ?string $mailCoordo, ?string $telCoordo, ?float $latitude, ?float $longitude)
    {
        $this->numero = $numero;
        $this->nom = $nom;
        $this->nomSalle = $nomSalle;
        $this->adresseSalle1 = $adresseSalle1;
        $this->adresseSalle2 = $adresseSalle2;
        $this->adresseSalle3 = $adresseSalle3;
        $this->codePostaleSalle = $codePostaleSalle;
        $this->villeSalle = $villeSalle;
        $this->siteWeb = $siteWeb;
        $this->nomCoordo = $nomCoordo;
        $this->prenomCoordo = $prenomCoordo;
        $this->mailCoordo = $mailCoordo;
        $this->telCoordo = $telCoordo;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }
    public function getNumero(): int
    {
        return $this->numero;
    }

    public function getNom(): string
    {
        return $this->nom;
    }

    public function getNomSalle(): ?string
    {
        return $this->nomSalle;
    }

    public function getAdresseSalle1(): ?string
    {
        return $this->adresseSalle1;
    }

    public function getAdresseSalle2(): ?string
    {
        return $this->adresseSalle2;
    }

    public function getAdresseSalle3(): ?string
    {
        return $this->adresseSalle3;
    }

    public function getCodePostaleSalle(): ?string
    {
        return $this->codePostaleSalle;
    }

    public function getVilleSalle(): ?string
    {
        return $this->villeSalle;
    }

    public function getSiteWeb(): ?string
    {
        return $this->siteWeb;
    }

    public function getNomCoordo(): ?string
    {
        return $this->nomCoordo;
    }

    public function getPrenomCoordo(): ?string
    {
        return $this->prenomCoordo;
    }

    public function getMailCoordo(): ?string
    {
        return $this->mailCoordo;
    }

    public function getTelCoordo(): ?string
    {
        return $this->telCoordo;
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }
}
