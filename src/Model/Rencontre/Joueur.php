<?php declare(strict_types=1);

namespace Alamirault\FFTTApi\Model\Rencontre;

final class Joueur
{
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
    private $licence;
    /**
     * @readonly
     * @var int|null
     */
    private $points;
    /**
     * @readonly
     * @var string|null
     */
    private $sexe;
    public function __construct(string $nom, string $prenom, string $licence, ?int $points, ?string $sexe)
    {
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->licence = $licence;
        $this->points = $points;
        $this->sexe = $sexe;
    }
    public function getNom(): string
    {
        return $this->nom;
    }

    public function getPrenom(): string
    {
        return $this->prenom;
    }

    public function getLicence(): string
    {
        return $this->licence;
    }

    public function getPoints(): ?int
    {
        return $this->points;
    }

    public function getSexe(): ?string
    {
        return $this->sexe;
    }
}
