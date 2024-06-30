<?php

namespace App\Entity;

use App\Repository\ClasseMatiereRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Mime\Message;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ClasseMatiereRepository::class)]
class ClasseMatiere
{
    #[ORM\Id]
    #[ORM\Column(name: 'id', type: 'string', length: 255, unique: true )]
    private ?string $id = null;

    #[ORM\ManyToOne(inversedBy: 'matieres')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Classe $classe = null;

    #[ORM\ManyToOne(inversedBy: 'classes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Matiere $matiere = null;

    #[ORM\Column]
    private ?int $coefficient = null;

    /**
     * @var Collection<int, TrancheHoraire>
     */
    #[ORM\OneToMany(targetEntity: TrancheHoraire::class, mappedBy: 'matiere')]
    private Collection $trancheHoraires;

    public function __construct()
    {
        $this->trancheHoraires = new ArrayCollection();
    }

    public function generateId() : void
    {
         $this->id= $this->classe->__toString(). $this->matiere->__toString();
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getClasse(): ?Classe
    {
        return $this->classe;
    }

    public function setClasse(?Classe $classe): static
    {
        $this->classe = $classe;

        return $this;
    }

    public function getMatiere(): ?Matiere
    {
        return $this->matiere;
    }

    public function setMatiere(?Matiere $matiere): static
    {
        $this->matiere = $matiere;

        return $this;
    }

    public function getCoefficient(): ?int
    {
        return $this->coefficient;
    }

    public function setCoefficient(int $coefficient): static
    {
        $this->coefficient = $coefficient;

        return $this;
    }

    public function __toString(): string
    {
        return $this->getMatiere()->__toString();
    }

    /**
     * @return Collection<int, TrancheHoraire>
     */
    public function getTrancheHoraires(): Collection
    {
        return $this->trancheHoraires;
    }

    public function addTrancheHoraire(TrancheHoraire $trancheHoraire): static
    {
        if (!$this->trancheHoraires->contains($trancheHoraire)) {
            $this->trancheHoraires->add($trancheHoraire);
            $trancheHoraire->setMatiere($this);
        }

        return $this;
    }

    public function removeTrancheHoraire(TrancheHoraire $trancheHoraire): static
    {
        if ($this->trancheHoraires->removeElement($trancheHoraire)) {
            // set the owning side to null (unless already changed)
            if ($trancheHoraire->getMatiere() === $this) {
                $trancheHoraire->setMatiere(null);
            }
        }

        return $this;
    }
}
