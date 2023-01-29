<?php declare(strict_types=1);

namespace Alamirault\FFTTApi\Model;

use Alamirault\FFTTApi\Model\Enums\NationaliteEnum;
use Alamirault\FFTTApi\Model\Enums\TypeLicenceEnum;

final class JoueurDetails
{
    /**
     * @readonly
     * @var int
     */
    private $idLicence;
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
     * @var \Alamirault\FFTTApi\Model\Enums\TypeLicenceEnum|null
     */
    private $typeLicence;
    /**
     * @readonly
     * @var \DateTime|null
     */
    private $dateValidation;
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
     * @var float|null
     */
    private $pointDebutSaison;
    /**
     * @readonly
     * @var float
     */
    private $pointsLicence;
    /**
     * @readonly
     * @var float|null
     */
    private $pointsMensuel;
    /**
     * @readonly
     * @var float|null
     */
    private $pointsMensuelAnciens;
    /**
     * @readonly
     * @var bool
     */
    private $isClasseNational;
    /**
     * @readonly
     * @var int|null
     */
    private $classementNational;
    /**
     * @readonly
     * @var \Alamirault\FFTTApi\Model\Enums\NationaliteEnum
     */
    private $nationalite;
    /**
     * @readonly
     * @var \DateTime|null
     */
    private $dateMutation;
    /**
     * @readonly
     * @var string|null
     */
    private $diplomeArbitre;
    /**
     * @readonly
     * @var string|null
     */
    private $diplomeJugeArbitre;
    /**
     * @readonly
     * @var string|null
     */
    private $diplomeTechnique;
    public function __construct(int $idLicence, string $licence, string $nom, string $prenom, ?TypeLicenceEnum $typeLicence, ?\DateTime $dateValidation, string $numClub, string $nomClub, bool $isHomme, string $categorie, ?float $pointDebutSaison, float $pointsLicence, ?float $pointsMensuel, ?float $pointsMensuelAnciens, bool $isClasseNational, ?int $classementNational, NationaliteEnum $nationalite, ?\DateTime $dateMutation, ?string $diplomeArbitre, ?string $diplomeJugeArbitre, ?string $diplomeTechnique)
    {
        $this->idLicence = $idLicence;
        $this->licence = $licence;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->typeLicence = $typeLicence;
        $this->dateValidation = $dateValidation;
        $this->numClub = $numClub;
        $this->nomClub = $nomClub;
        $this->isHomme = $isHomme;
        $this->categorie = $categorie;
        // TODO: Créer une Enum pour convertir "categorie" en libellés plus explicites
        $this->pointDebutSaison = $pointDebutSaison;
        $this->pointsLicence = $pointsLicence;
        $this->pointsMensuel = $pointsMensuel;
        $this->pointsMensuelAnciens = $pointsMensuelAnciens;
        $this->isClasseNational = $isClasseNational;
        $this->classementNational = $classementNational;
        $this->nationalite = $nationalite;
        $this->dateMutation = $dateMutation;
        $this->diplomeArbitre = $diplomeArbitre;
        $this->diplomeJugeArbitre = $diplomeJugeArbitre;
        $this->diplomeTechnique = $diplomeTechnique;
    }
    public function getIdLicence(): int
    {
        return $this->idLicence;
    }

    public function getDiplomeArbitre(): ?string
    {
        return $this->diplomeArbitre;
    }

    public function getDiplomeJugeArbitre(): ?string
    {
        return $this->diplomeJugeArbitre;
    }

    public function getDiplomeTechnique(): ?string
    {
        return $this->diplomeTechnique;
    }

    public function getClassementNational(): ?int
    {
        return $this->classementNational;
    }

    public function getNationalite(): NationaliteEnum
    {
        return $this->nationalite;
    }

    public function getDateValidation(): ?\DateTime
    {
        return $this->dateValidation;
    }

    public function getDateMutation(): ?\DateTime
    {
        return $this->dateMutation;
    }

    public function getTypeLicence(): ?TypeLicenceEnum
    {
        return $this->typeLicence;
    }

    public function isClasseNational(): bool
    {
        return $this->isClasseNational;
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

    public function getPointDebutSaison(): ?float
    {
        return $this->pointDebutSaison;
    }

    public function getPointsLicence(): float
    {
        return $this->pointsLicence;
    }

    public function getPointsMensuel(): ?float
    {
        return $this->pointsMensuel;
    }

    public function getPointsMensuelAnciens(): ?float
    {
        return $this->pointsMensuelAnciens;
    }
}
