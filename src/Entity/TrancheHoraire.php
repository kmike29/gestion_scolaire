<?php

namespace App\Entity;

use App\Repository\TrancheHoraireRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\UX\Turbo\Attribute\Broadcast;

#[ORM\Entity(repositoryClass: TrancheHoraireRepository::class)]
#[Broadcast]
class TrancheHoraire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $jour = null;

    #[ORM\ManyToOne(inversedBy: 'trancheHoraires')]
    private ?EmploiDuTemps $emploiDuTemps = null;

    #[ORM\ManyToOne(inversedBy: 'trancheHoraires')]
    private ?Personnel $professeur = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $debut = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $fin = null;

    #[ORM\ManyToOne(inversedBy: 'trancheHoraires')]
    #[ORM\JoinColumn(nullable: false)]
    private ?ClasseMatiere $matiere = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getJour(): ?\DateTimeInterface
    {
        return $this->jour;
    }

    public function setJour(\DateTimeInterface $jour): static
    {
        $this->jour = $jour;

        return $this;
    }

    public function getEmploiDuTemps(): ?EmploiDuTemps
    {
        return $this->emploiDuTemps;
    }

    public function setEmploiDuTemps(?EmploiDuTemps $emploiDuTemps): static
    {
        $this->emploiDuTemps = $emploiDuTemps;

        return $this;
    }

    public function getProfesseur(): ?Personnel
    {
        return $this->professeur;
    }

    public function setProfesseur(?Personnel $professeur): static
    {
        $this->professeur = $professeur;

        return $this;
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

    public function getMatiere(): ?ClasseMatiere
    {
        return $this->matiere;
    }

    public function setMatiere(?ClasseMatiere $matiere): static
    {
        $this->matiere = $matiere;

        return $this;
    }
}
