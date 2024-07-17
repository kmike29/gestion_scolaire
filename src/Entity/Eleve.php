<?php

namespace App\Entity;

use App\Repository\EleveRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EleveRepository::class)]
class Eleve
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $prenoms = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateDeNaissance = null;

    #[ORM\Column(length: 100)]
    private ?string $nationalite = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $ecoleDeProvenance = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateDInscription = null;

    #[ORM\Column(length: 10)]
    private ?string $matricule = null;

    #[ORM\Column(length: 255)]
    private ?string $lieuDeNaissance = null;

    /**
     * @var Collection<int, Tuteur>
     */
    #[ORM\ManyToMany(targetEntity: Tuteur::class, inversedBy: 'enfants')]
    private Collection $parents;

    #[ORM\Column(length: 255)]
    private ?string $photo = null;

    #[ORM\Column(length: 10)]
    private ?string $sexe = null;

    #[ORM\ManyToOne(inversedBy: 'eleves')]
    private ?ClasseAnneeScolaire $classeActuelle = null;

    /**
     * @var Collection<int, Inscription>
     */
    #[ORM\OneToMany(targetEntity: Inscription::class, mappedBy: 'Eleve')]
    private Collection $inscriptions;

    public function __construct()
    {
        $this->parents = new ArrayCollection();
        $this->inscriptions = new ArrayCollection();
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

    public function getDateDeNaissance(): ?\DateTimeInterface
    {
        return $this->dateDeNaissance;
    }

    public function setDateDeNaissance(\DateTimeInterface $dateDeNaissance): static
    {
        $this->dateDeNaissance = $dateDeNaissance;

        return $this;
    }

    public function getNationalite(): ?string
    {
        return $this->nationalite;
    }

    public function setNationalite(string $nationalite): static
    {
        $this->nationalite = $nationalite;

        return $this;
    }

    public function getEcoleDeProvenance(): ?string
    {
        return $this->ecoleDeProvenance;
    }

    public function setEcoleDeProvenance(?string $ecoleDeProvenance): static
    {
        $this->ecoleDeProvenance = $ecoleDeProvenance;

        return $this;
    }

    public function getDateDInscription(): ?\DateTimeInterface
    {
        return $this->dateDInscription;
    }

    public function setDateDInscription(\DateTimeInterface $dateDInscription): static
    {
        $this->dateDInscription = $dateDInscription;

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

    public function getLieuDeNaissance(): ?string
    {
        return $this->lieuDeNaissance;
    }

    public function setLieuDeNaissance(string $lieuDeNaissance): static
    {
        $this->lieuDeNaissance = $lieuDeNaissance;

        return $this;
    }

    /**
     * @return Collection<int, Tuteur>
     */
    public function getParents(): Collection
    {
        return $this->parents;
    }

    public function addParent(Tuteur $parent): static
    {
        if (!$this->parents->contains($parent)) {
            $this->parents->add($parent);
        }

        return $this;
    }

    public function removeParent(Tuteur $parent): static
    {
        $this->parents->removeElement($parent);

        return $this;
    }

    public function __toString(): string
    {
        return $this->nom.' '.$this->prenoms;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(string $photo): static
    {
        $this->photo = $photo;

        return $this;
    }

    public function getSexe(): ?string
    {
        return $this->sexe;
    }

    public function setSexe(string $sexe): static
    {
        $this->sexe = $sexe;

        return $this;
    }

    public function getClasseActuelle(): ?ClasseAnneeScolaire
    {
        return $this->classeActuelle;
    }

    public function setClasseActuelle(?ClasseAnneeScolaire $classeActuelle): static
    {
        $this->classeActuelle = $classeActuelle;

        return $this;
    }

    /**
     * @return Collection<int, Inscription>
     */
    public function getInscriptions(): Collection
    {
        return $this->inscriptions;
    }

    public function addInscription(Inscription $inscription): static
    {
        if (!$this->inscriptions->contains($inscription)) {
            $this->inscriptions->add($inscription);
            $inscription->setEleve($this);
        }

        return $this;
    }

    public function removeInscription(Inscription $inscription): static
    {
        if ($this->inscriptions->removeElement($inscription)) {
            // set the owning side to null (unless already changed)
            if ($inscription->getEleve() === $this) {
                $inscription->setEleve(null);
            }
        }

        return $this;
    }
}
