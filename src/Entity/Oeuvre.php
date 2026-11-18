<?php

namespace App\Entity;

use App\Repository\OeuvreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OeuvreRepository::class)]
class Oeuvre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $titre = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $date_sortie = null;

    #[ORM\ManyToOne(inversedBy: 'oeuvres')]
    private ?TypeOeuvre $typeOeuvre = null;

    #[ORM\ManyToOne(inversedBy: 'oeuvres')]
    private ?TypeOeuvre $TypeOeuvre = null;

    /**
     * @var Collection<int, Categorie>
     */
    #[ORM\ManyToMany(targetEntity: Categorie::class, mappedBy: 'oeuvre')]
    private Collection $categories;

    /**
     * @var Collection<int, Auteur>
     */
    #[ORM\ManyToMany(targetEntity: Auteur::class, mappedBy: 'oeuvre')]
    private Collection $auteurs;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->auteurs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDateSortie(): ?\DateTime
    {
        return $this->date_sortie;
    }

    public function setDateSortie(\DateTime $date_sortie): static
    {
        $this->date_sortie = $date_sortie;

        return $this;
    }

    public function getTypeOeuvre(): ?TypeOeuvre
    {
        return $this->typeOeuvre;
    }

    public function setTypeOeuvre(?TypeOeuvre $typeOeuvre): static
    {
        $this->typeOeuvre = $typeOeuvre;

        return $this;
    }

    /**
     * @return Collection<int, Categorie>
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Categorie $category): static
    {
        if (!$this->categories->contains($category)) {
            $this->categories->add($category);
            $category->addOeuvre($this);
        }

        return $this;
    }

    public function removeCategory(Categorie $category): static
    {
        if ($this->categories->removeElement($category)) {
            $category->removeOeuvre($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Auteur>
     */
    public function getAuteurs(): Collection
    {
        return $this->auteurs;
    }

    public function addAuteur(Auteur $auteur): static
    {
        if (!$this->auteurs->contains($auteur)) {
            $this->auteurs->add($auteur);
            $auteur->addOeuvre($this);
        }

        return $this;
    }

    public function removeAuteur(Auteur $auteur): static
    {
        if ($this->auteurs->removeElement($auteur)) {
            $auteur->removeOeuvre($this);
        }

        return $this;
    }
}
