<?php

namespace App\Entity;

use App\Repository\EmpruntRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;

#[ORM\Entity(repositoryClass: EmpruntRepository::class)]
class Emprunt
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: false)]
    private ?\DateTimeImmutable $dateEmprunt = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: false)]
    private ?\DateTimeImmutable $dateRetourPrevu = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $dateRetourReelle = null;

    #[ORM\ManyToOne(inversedBy: 'emprunts')]
    private ?Utilisateur $utilisateur = null;

    #[ORM\ManyToOne(inversedBy: 'emprunts')]
    private ?Exemplaire $exemplaire = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateEmprunt(): ?\DateTimeImmutable
    {
        return $this->dateEmprunt;
    }

    public function setDateEmprunt(\DateTimeImmutable $dateEmprunt): static
    {
        $this->dateEmprunt = $dateEmprunt;

        return $this;
    }

    public function getDateRetourPrevu(): ?\DateTimeImmutable
    {
        return $this->dateRetourPrevu;
    }

    public function setDateRetourPrevu(\DateTimeImmutable $dateRetourPrevu): static
    {
        $this->dateRetourPrevu = $dateRetourPrevu;

        return $this;
    }

    public function getDateRetourReelle(): ?\DateTimeImmutable
    {
        return $this->dateRetourReelle;
    }

    public function setDateRetourReelle(?\DateTimeImmutable $dateRetourReelle): static
    {
        $this->dateRetourReelle = $dateRetourReelle;

        return $this;
    }

    public function getUtilisateur(): ?Utilisateur
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?Utilisateur $utilisateur): static
    {
        if ($this->utilisateur === $utilisateur) {
            return $this;
        }

        $previous = $this->utilisateur;
        $this->utilisateur = $utilisateur;

        $previous?->removeEmprunt($this);
        $utilisateur?->addEmprunt($this);

        return $this;
    }

    public function getExemplaire(): ?Exemplaire
    {
        return $this->exemplaire;
    }

    public function setExemplaire(?Exemplaire $exemplaire): static
    {
        if ($this->exemplaire === $exemplaire) {
            return $this;
        }

        $previous = $this->exemplaire;
        $this->exemplaire = $exemplaire;

        $previous?->removeEmprunt($this);
        $exemplaire?->addEmprunt($this);

        return $this;
    }
}
