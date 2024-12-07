<?php

namespace App\Entity;

use App\Repository\ClasseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ClasseRepository::class)]
class Classe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NoSuspiciousCharacters]
    #[Assert\Length(
        min: 2,
        max: 10,
        minMessage: 'Le nom doit contenir au moins {{ limit }} lettres',
        maxMessage: 'Le nom ne doit pas contenir plus de {{ limit }} ',
    )]
    #[ORM\Column(length: 10)]
    private ?string $nom = null;

    #[ORM\OneToOne(targetEntity: self::class, cascade: ['persist', 'remove'])]
    private ?self $classeSuperieure = null;

    #[ORM\ManyToOne(inversedBy: 'classes')]
    private ?Niveau $niveau = null;

    /**
     * @var Collection<int, ClasseMatiere>
     */
    #[ORM\OneToMany(targetEntity: ClasseMatiere::class, mappedBy: 'classe', orphanRemoval: true, cascade: ['persist', 'remove'])]
    private Collection $matieres;


    #[Assert\Positive(message : 'Les frais doivent etre supérieur à 0')]
    #[ORM\Column]
    private ?int $fraisScolariteDeBase = null;

    #[Assert\Positive(message : 'Les frais doivent etre supérieur à 0')]
    #[ORM\Column]
    private ?int $fraisInscriptionDeBase = null;

    #[ORM\ManyToOne(inversedBy: 'classesDeBase')]
    private ?Ecole $ecole = null;


    public function __construct()
    {
        $this->matieres = new ArrayCollection();
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

    public function getClasseSuperieure(): ?self
    {
        return $this->classeSuperieure;
    }

    public function setClasseSuperieure(?self $classeSuperieure): static
    {
        $this->classeSuperieure = $classeSuperieure;

        return $this;
    }

    public function getNiveau(): ?Niveau
    {
        return $this->niveau;
    }

    public function setNiveau(?Niveau $niveau): static
    {
        $this->niveau = $niveau;

        return $this;
    }


    public function __toString(): string
    {
        return $this->nom;
    }

    public function getNomNiveau(): string
    {
        return $this->getNiveau()->getNom();
    }

    /**
     * @return Collection<int, ClasseMatiere>
     */
    public function getMatieres(): Collection
    {
        return $this->matieres;
    }

    public function addMatiere(ClasseMatiere $matiere): static
    {
        if (!$this->matieres->contains($matiere)) {
            $this->matieres->add($matiere);
            $matiere->setClasse($this);
        }

        return $this;
    }

    public function removeMatiere(ClasseMatiere $matiere): static
    {
        if ($this->matieres->removeElement($matiere)) {
            // set the owning side to null (unless already changed)
            if ($matiere->getClasse() === $this) {
                $matiere->setClasse(null);
            }
        }

        return $this;
    }

    public function getFraisScolariteDeBase(): ?int
    {
        return $this->fraisScolariteDeBase;
    }

    public function setFraisScolariteDeBase(int $scolariteDeBase): static
    {
        $this->fraisScolariteDeBase = $scolariteDeBase;

        return $this;
    }

    public function getFraisInscriptionDeBase(): ?int
    {
        return $this->fraisInscriptionDeBase;
    }

    public function setFraisInscriptionDeBase(int $fraisInscriptionDeBase): static
    {
        $this->fraisInscriptionDeBase = $fraisInscriptionDeBase;

        return $this;
    }

    public function getEcole(): ?Ecole
    {
        return $this->ecole;
    }

    public function setEcole(?Ecole $ecole): static
    {
        $this->ecole = $ecole;

        return $this;
    }



}
