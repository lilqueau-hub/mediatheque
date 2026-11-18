<?php

namespace App\Entity;

use App\Repository\ExemplaireRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ExemplaireRepository::class)]
class Exemplaire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?bool $disponibilite = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $code_inventaire = null;

    /**
     * @var Collection<int, Oeuvre>
     */
    #[ORM\ManyToMany(targetEntity: Oeuvre::class)]
    private Collection $Oeuvre;

    /**
     * @var Collection<int, Emprunt>
     */
    #[ORM\OneToMany(targetEntity: Emprunt::class, mappedBy: 'exemplaire')]
    private Collection $emprunts;

    public function __construct()
    {
        $this->Oeuvre = new ArrayCollection();
        $this->emprunts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isDisponibilite(): ?bool
    {
        return $this->disponibilite;
    }

    public function setDisponibilite(bool $disponibilite): static
    {
        $this->disponibilite = $disponibilite;

        return $this;
    }

    public function getCodeInventaire(): ?string
    {
        return $this->code_inventaire;
    }

    public function setCodeInventaire(?string $code_inventaire): static
    {
        $this->code_inventaire = $code_inventaire;

        return $this;
    }

    /**
     * @return Collection<int, Oeuvre>
     */
    public function getOeuvre(): Collection
    {
        return $this->Oeuvre;
    }

    public function addOeuvre(Oeuvre $oeuvre): static
    {
        if (!$this->Oeuvre->contains($oeuvre)) {
            $this->Oeuvre->add($oeuvre);
        }

        return $this;
    }

    public function removeOeuvre(Oeuvre $oeuvre): static
    {
        $this->Oeuvre->removeElement($oeuvre);

        return $this;
    }

    /**
     * @return Collection<int, Emprunt>
     */
    public function getEmprunts(): Collection
    {
        return $this->emprunts;
    }

    public function addEmprunt(Emprunt $emprunt): static
    {
        if (!$this->emprunts->contains($emprunt)) {
            $this->emprunts->add($emprunt);
            $emprunt->setExemplaire($this);
        }

        return $this;
    }

    public function removeEmprunt(Emprunt $emprunt): static
    {
        if ($this->emprunts->removeElement($emprunt)) {
            // set the owning side to null (unless already changed)
            if ($emprunt->getExemplaire() === $this) {
                $emprunt->setExemplaire(null);
            }
        }

        return $this;
    }
}
