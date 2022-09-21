<?php declare(strict_types=1);

namespace Alamirault\FFTTApi\Model;

final class Joueur
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
    private $clubId;
    /**
     * @readonly
     * @var string
     */
    private $club;
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
     * @var string|null
     * @readonly
     */
    private $points;
    /**
     * @param string|null $points Points du joueur ou classement si classé dans les 1000 premiers français
     */
    public function __construct(string $licence, string $clubId, string $club, string $nom, string $prenom, ?string $points)
    {
        $this->licence = $licence;
        $this->clubId = $clubId;
        $this->club = $club;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->points = $points;
    }
    public function getLicence(): string
    {
        return $this->licence;
    }

    public function getClubId(): string
    {
        return $this->clubId;
    }

    public function getClub(): string
    {
        return $this->club;
    }

    public function getNom(): string
    {
        return $this->nom;
    }

    public function getPrenom(): string
    {
        return $this->prenom;
    }

    public function getPoints(): ?string
    {
        return $this->points;
    }
}
