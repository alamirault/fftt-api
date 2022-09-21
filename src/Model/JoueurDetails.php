<?php declare(strict_types=1);

namespace Alamirault\FFTTApi\Model;

final class JoueurDetails
{
    /**
     * @readonly
     * @var string
     */
    private $licence;
    /**
     * @readonly
     * @var string
     */
    private $nom;
    /**
     * @readonly
     * @var string
     */
    private $prenom;
    /**
     * @readonly
     * @var string
     */
    private $numClub;
    /**
     * @readonly
     * @var string
     */
    private $nomClub;
    /**
     * @readonly
     * @var bool
     */
    private $isHomme;
    /**
     * @readonly
     * @var string
     */
    private $categorie;
    /**
     * @readonly
     * @var float
     */
    private $pointDebutSaison;
    /**
     * @readonly
     * @var float
     */
    private $pointsLicence;
    /**
     * @readonly
     * @var float
     */
    private $pointsMensuel;
    /**
     * @readonly
     * @var float
     */
    private $pointsMensuelAnciens;
    public function __construct(string $licence, string $nom, string $prenom, string $numClub, string $nomClub, bool $isHomme, string $categorie, float $pointDebutSaison, float $pointsLicence, float $pointsMensuel, float $pointsMensuelAnciens)
    {
        $this->licence = $licence;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->numClub = $numClub;
        $this->nomClub = $nomClub;
        $this->isHomme = $isHomme;
        $this->categorie = $categorie;
        $this->pointDebutSaison = $pointDebutSaison;
        $this->pointsLicence = $pointsLicence;
        $this->pointsMensuel = $pointsMensuel;
        $this->pointsMensuelAnciens = $pointsMensuelAnciens;
    }
    public function getLicence(): string
    {
        return $this->licence;
    }

    public function getNom(): string
    {
        return $this->nom;
    }

    public function getPrenom(): string
    {
        return $this->prenom;
    }

    public function getNumClub(): string
    {
        return $this->numClub;
    }

    public function getNomClub(): string
    {
        return $this->nomClub;
    }

    public function isHomme(): bool
    {
        return $this->isHomme;
    }

    public function getCategorie(): string
    {
        return $this->categorie;
    }

    public function getPointDebutSaison(): float
    {
        return $this->pointDebutSaison;
    }

    public function getPointsLicence(): float
    {
        return $this->pointsLicence;
    }

    public function getPointsMensuel(): float
    {
        return $this->pointsMensuel;
    }

    public function getPointsMensuelAnciens(): float
    {
        return $this->pointsMensuelAnciens;
    }
}
