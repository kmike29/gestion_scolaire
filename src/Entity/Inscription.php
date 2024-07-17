<?php

namespace App\Entity;

use App\Repository\InscriptionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InscriptionRepository::class)]
class Inscription
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'inscriptions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Eleve $Eleve = null;

    #[ORM\ManyToOne(inversedBy: 'inscriptions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?AnneeScolaire $AnneeScolaire = null;

    #[ORM\ManyToOne(inversedBy: 'inscriptions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?ClasseAnneeScolaire $Classe = null;

    #[ORM\Column]
    private ?int $montantRestant = null;

    #[ORM\Column]
    private ?int $montantRemis = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEleve(): ?Eleve
    {
        return $this->Eleve;
    }

    public function setEleve(?Eleve $Eleve): static
    {
        $this->Eleve = $Eleve;

        return $this;
    }

    public function getAnneeScolaire(): ?AnneeScolaire
    {
        return $this->AnneeScolaire;
    }

    public function setAnneeScolaire(?AnneeScolaire $AnneeScolaire): static
    {
        $this->AnneeScolaire = $AnneeScolaire;

        return $this;
    }

    public function getClasse(): ?ClasseAnneeScolaire
    {
        return $this->Classe;
    }

    public function setClasse(?ClasseAnneeScolaire $Classe): static
    {
        $this->Classe = $Classe;

        return $this;
    }

    public function getMontantRestant(): ?int
    {
        return $this->montantRestant;
    }

    public function setMontantRestant(int $montantRestant): static
    {
        $this->montantRestant = $montantRestant;

        return $this;
    }

    public function getMontantRemis(): ?int
    {
        return $this->montantRemis;
    }

    public function setMontantRemis(int $montantRemis): static
    {
        $this->montantRemis = $montantRemis;

        return $this;
    }
}
