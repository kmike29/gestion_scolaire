<?php

namespace App\Entity;

use App\Repository\EmploiDuTempsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\UX\Turbo\Attribute\Broadcast;

#[ORM\Entity(repositoryClass: EmploiDuTempsRepository::class)]
#[Broadcast]
class EmploiDuTemps
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'emploisDuTemps')]
    private ?ClasseAnneeScolaire $classe = null;

    /**
     * @var Collection<int, TrancheHoraire>
     */
    #[ORM\OneToMany(targetEntity: TrancheHoraire::class, mappedBy: 'emploiDuTemps')]
    private Collection $trancheHoraires;

    public function __construct()
    {
        $this->trancheHoraires = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getClasse(): ?ClasseAnneeScolaire
    {
        return $this->classe;
    }

    public function setClasse(?ClasseAnneeScolaire $classe): static
    {
        $this->classe = $classe;

        return $this;
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
            $trancheHoraire->setEmploiDuTemps($this);
        }

        return $this;
    }

    public function removeTrancheHoraire(TrancheHoraire $trancheHoraire): static
    {
        if ($this->trancheHoraires->removeElement($trancheHoraire)) {
            // set the owning side to null (unless already changed)
            if ($trancheHoraire->getEmploiDuTemps() === $this) {
                $trancheHoraire->setEmploiDuTemps(null);
            }
        }

        return $this;
    }
}
