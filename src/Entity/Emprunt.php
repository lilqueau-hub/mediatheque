<?php

namespace App\Entity;

use App\Repository\EmpruntRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EmpruntRepository::class)]
class Emprunt
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTime $date_emprunt = null;

    #[ORM\Column]
    private ?\DateTime $date_retour_prevu = null;

    #[ORM\Column]
    private ?\DateTime $date_retour_reel = null;

    #[ORM\ManyToOne(inversedBy: 'emprunts')]
    private ?Utilisateur $utilisateur = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateEmprunt(): ?\DateTime
    {
        return $this->date_emprunt;
    }

    public function setDateEmprunt(\DateTime $date_emprunt): static
    {
        $this->date_emprunt = $date_emprunt;

        return $this;
    }

    public function getDateRetourPrevu(): ?\DateTime
    {
        return $this->date_retour_prevu;
    }

    public function setDateRetourPrevu(\DateTime $date_retour_prevu): static
    {
        $this->date_retour_prevu = $date_retour_prevu;

        return $this;
    }

    public function getDateRetourReel(): ?\DateTime
    {
        return $this->date_retour_reel;
    }

    public function setDateRetourReel(\DateTime $date_retour_reel): static
    {
        $this->date_retour_reel = $date_retour_reel;

        return $this;
    }

    public function getUtilisateur(): ?Utilisateur
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?Utilisateur $utilisateur): static
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }
}
