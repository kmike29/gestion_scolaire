<?php

namespace App\Entity;

use App\Repository\PersonnelRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PersonnelRepository::class)]
class Personnel
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $prenoms = null;

    #[ORM\Column(length: 10)]
    private ?string $matricule = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateDeNaissance = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateAjout = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $acteDeNaissance = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $cv = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $numeroCNSS = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $compteBancaire = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $diplomesAcademiques = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $diplomesProfessionnels = null;

    /**
     * @var Collection<int, TrancheHoraire>
     */
    #[ORM\OneToMany(targetEntity: TrancheHoraire::class, mappedBy: 'professeur')]
    private Collection $tranchesHoraires;

    public function __construct()
    {
        $this->tranchesHoraires = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenoms(): ?string
    {
        return $this->prenoms;
    }

    public function setPrenoms(string $prenoms): static
    {
        $this->prenoms = $prenoms;

        return $this;
    }

    public function getMatricule(): ?string
    {
        return $this->matricule;
    }

    public function setMatricule(string $matricule): static
    {
        $this->matricule = $matricule;

        return $this;
    }

    public function getDateDeNaissance(): ?\DateTimeInterface
    {
        return $this->dateDeNaissance;
    }

    public function setDateDeNaissance(\DateTimeInterface $dateDeNaissance): static
    {
        $this->dateDeNaissance = $dateDeNaissance;

        return $this;
    }

    public function getDateAjout(): ?\DateTimeInterface
    {
        return $this->dateAjout;
    }

    public function setDateAjout(\DateTimeInterface $dateAjout): static
    {
        $this->dateAjout = $dateAjout;

        return $this;
    }

    public function getActeDeNaissance(): ?string
    {
        return $this->acteDeNaissance;
    }

    public function setActeDeNaissance(?string $acteDeNaissance): static
    {
        $this->acteDeNaissance = $acteDeNaissance;

        return $this;
    }

    public function getCv(): ?string
    {
        return $this->cv;
    }

    public function setCv(?string $cv): static
    {
        $this->cv = $cv;

        return $this;
    }

    public function getNumeroCNSS(): ?string
    {
        return $this->numeroCNSS;
    }

    public function setNumeroCNSS(string $numeroCNSS): static
    {
        $this->numeroCNSS = $numeroCNSS;

        return $this;
    }

    public function getCompteBancaire(): ?string
    {
        return $this->compteBancaire;
    }

    public function setCompteBancaire(?string $compteBancaire): static
    {
        $this->compteBancaire = $compteBancaire;

        return $this;
    }

    public function getDiplomesAcademiques(): ?string
    {
        return $this->diplomesAcademiques;
    }

    public function setDiplomesAcademiques(?string $diplomesAcademiques): static
    {
        $this->diplomesAcademiques = $diplomesAcademiques;

        return $this;
    }

    public function getDiplomesProfessionnels(): ?string
    {
        return $this->diplomesProfessionnels;
    }

    public function setDiplomesProfessionnels(?string $diplomesProfessionnels): static
    {
        $this->diplomesProfessionnels = $diplomesProfessionnels;

        return $this;
    }

    /**
     * @return Collection<int, TrancheHoraire>
     */
    public function getTrancheHoraires(): Collection
    {
        return $this->tranchesHoraires;
    }

    public function addTrancheHoraire(TrancheHoraire $trancheHoraire): static
    {
        if (!$this->tranchesHoraires->contains($trancheHoraire)) {
            $this->tranchesHoraires->add($trancheHoraire);
            $trancheHoraire->setProfesseur($this);
        }

        return $this;
    }

    public function removeTrancheHoraire(TrancheHoraire $trancheHoraire): static
    {
        if ($this->tranchesHoraires->removeElement($trancheHoraire)) {
            // set the owning side to null (unless already changed)
            if ($trancheHoraire->getProfesseur() === $this) {
                $trancheHoraire->setProfesseur(null);
            }
        }

        return $this;
    }
}
