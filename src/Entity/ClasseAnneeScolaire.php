<?php

namespace App\Entity;

use App\Repository\ClasseAnneeScolaireRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClasseAnneeScolaireRepository::class)]
class ClasseAnneeScolaire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'classes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?AnneeScolaire $anneeScolaire = null;

    #[ORM\ManyToOne]
    private ?Classe $Classe = null;

    /**
     * @var Collection<int, Personnel>
     */
    #[ORM\ManyToMany(targetEntity: Personnel::class)]
    private Collection $professeurPrincipal;

    /**
     * @var Collection<int, EmploiDuTemps>
     */
    #[ORM\OneToMany(targetEntity: EmploiDuTemps::class, mappedBy: 'classe')]
    private Collection $emploisDuTemps;

    public function __construct()
    {
        $this->professeurPrincipal = new ArrayCollection();
        $this->emploisDuTemps = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAnneeScolaire(): ?AnneeScolaire
    {
        return $this->anneeScolaire;
    }

    public function setAnneeScolaire(?AnneeScolaire $anneeScolaire): static
    {
        $this->anneeScolaire = $anneeScolaire;

        return $this;
    }

    public function getClasse(): ?Classe
    {
        return $this->Classe;
    }

    public function setClasse(?Classe $Classe): static
    {
        $this->Classe = $Classe;

        return $this;
    }

    public function __toString(): string
    {
        return $this->getClasse()->getNom().' '.$this->getAnneeScolaire()->getDesignation();
    }

    /**
     * @return Collection<int, Personnel>
     */
    public function getProfesseurPrincipal(): Collection
    {
        return $this->professeurPrincipal;
    }

    public function addProfesseurPrincipal(Personnel $professeurPrincipal): static
    {
        if (!$this->professeurPrincipal->contains($professeurPrincipal)) {
            $this->professeurPrincipal->add($professeurPrincipal);
        }

        return $this;
    }

    public function removeProfesseurPrincipal(Personnel $professeurPrincipal): static
    {
        $this->professeurPrincipal->removeElement($professeurPrincipal);

        return $this;
    }

    /**
     * @return Collection<int, EmploiDuTemps>
     */
    public function getEmploisDuTemps(): Collection
    {
        return $this->emploisDuTemps;
    }

    public function addEmploisDuTemp(EmploiDuTemps $emploisDuTemp): static
    {
        if (!$this->emploisDuTemps->contains($emploisDuTemp)) {
            $this->emploisDuTemps->add($emploisDuTemp);
            $emploisDuTemp->setClasse($this);
        }

        return $this;
    }

    public function removeEmploisDuTemp(EmploiDuTemps $emploisDuTemp): static
    {
        if ($this->emploisDuTemps->removeElement($emploisDuTemp)) {
            // set the owning side to null (unless already changed)
            if ($emploisDuTemp->getClasse() === $this) {
                $emploisDuTemp->setClasse(null);
            }
        }

        return $this;
    }
}