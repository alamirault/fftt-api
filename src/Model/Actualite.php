<?php declare(strict_types=1);

namespace Alamirault\FFTTApi\Model;

final class Actualite
{
    /**
     * @readonly
     * @var \DateTime
     */
    private $date;
    /**
     * @readonly
     * @var string
     */
    private $titre;
    /**
     * @readonly
     * @var string
     */
    private $description;
    /**
     * @readonly
     * @var string
     */
    private $url;
    /**
     * @readonly
     * @var string
     */
    private $photo;
    /**
     * @readonly
     * @var string
     */
    private $categorie;
    public function __construct(\DateTime $date, string $titre, string $description, string $url, string $photo, string $categorie)
    {
        $this->date = $date;
        $this->titre = $titre;
        $this->description = $description;
        $this->url = $url;
        $this->photo = $photo;
        $this->categorie = $categorie;
    }
    public function getDate(): \DateTime
    {
        return $this->date;
    }

    public function getTitre(): string
    {
        return $this->titre;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getPhoto(): string
    {
        return $this->photo;
    }

    public function getCategorie(): string
    {
        return $this->categorie;
    }
}
