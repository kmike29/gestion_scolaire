<?php

namespace App\Entity;

use App\Repository\AnneeScolaireRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AnneeScolaireRepository::class)]
class AnneeScolaire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $debut = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $fin = null;

    /**
     * @var Collection<int, ClasseAnneeScolaire>
     */
    #[ORM\OneToMany(targetEntity: ClasseAnneeScolaire::class, mappedBy: 'anneeScolaire')]
    private Collection $classes;

    #[ORM\Column]
    private ?bool $active = null;

    #[ORM\Column(length: 10)]
    private ?string $designation = null;

    /**
     * @var Collection<int, Facture>
     */
    #[ORM\OneToMany(targetEntity: Facture::class, mappedBy: 'anneeScolaire')]
    private Collection $factures;

    public function __construct()
    {
        $this->classes = new ArrayCollection();
        $this->factures = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDebut(): ?\DateTimeInterface
    {
        return $this->debut;
    }

    public function setDebut(\DateTimeInterface $debut): static
    {
        $this->debut = $debut;

        return $this;
    }

    public function getFin(): ?\DateTimeInterface
    {
        return $this->fin;
    }

    public function setFin(\DateTimeInterface $fin): static
    {
        $this->fin = $fin;

        return $this;
    }

    /**
     * @return Collection<int, ClasseAnneeScolaire>
     */
    public function getClasses(): Collection
    {
        return $this->classes;
    }

    public function addClass(ClasseAnneeScolaire $class): static
    {
        if (!$this->classes->contains($class)) {
            $this->classes->add($class);
            $class->setAnneeScolaire($this);
        }

        return $this;
    }

    public function removeClass(ClasseAnneeScolaire $class): static
    {
        if ($this->classes->removeElement($class)) {
            // set the owning side to null (unless already changed)
            if ($class->getAnneeScolaire() === $this) {
                $class->setAnneeScolaire(null);
            }
        }

        return $this;
    }

    public function isActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): static
    {
        $this->active = $active;

        return $this;
    }

    public function getDesignation(): ?string
    {
        return $this->designation;
    }

    public function setDesignation(string $designation): static
    {
        $this->designation = $designation;

        return $this;
    }

    public function __toString(): string
    {
        return $this->designation;
    }

    /**
     * @return Collection<int, Facture>
     */
    public function getFactures(): Collection
    {
        return $this->factures;
    }

    public function addFacture(Facture $facture): static
    {
        if (!$this->factures->contains($facture)) {
            $this->factures->add($facture);
            $facture->setAnneeScolaire($this);
        }

        return $this;
    }

    public function removeFacture(Facture $facture): static
    {
        if ($this->factures->removeElement($facture)) {
            // set the owning side to null (unless already changed)
            if ($facture->getAnneeScolaire() === $this) {
                $facture->setAnneeScolaire(null);
            }
        }

        return $this;
    }

}
