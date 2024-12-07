<?php

namespace App\Entity;

use App\Repository\EleveRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: EleveRepository::class)]
class Eleve
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\Length(
        min: 2,
        max: 50,
        minMessage: 'Le nom doit contenir au moins {{ limit }} lettres',
        maxMessage: 'Le nom ne doit pas contenir plus de {{ limit }} ',
    )]
    #[Assert\NoSuspiciousCharacters]
    #[ORM\Column(length: 100)]
    private ?string $nom = null;

    #[Assert\Length(
        min: 2,
        max: 50,
        minMessage: 'Les prénoms doivent contenir au moins {{ limit }} lettres',
        maxMessage: 'Le prénoms ne doivent pas contenir plus de {{ limit }} lettres ',
    )]
    #[Assert\NoSuspiciousCharacters]
    #[ORM\Column(length: 255)]
    private ?string $prenoms = null;

    #[Assert\NoSuspiciousCharacters]
    #[ORM\Column(length: 100, nullable: true)]
    private ?string $nationalite = null;

    #[Assert\NoSuspiciousCharacters]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $ecoleDeProvenance = null;

    #[Assert\NoSuspiciousCharacters]
    #[ORM\Column(length: 10, nullable: true)]
    private ?string $matricule = null;

    #[Assert\NoSuspiciousCharacters]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $lieuDeNaissance = null;

    /**
     * @var Collection<int, Tuteur>
     */
    #[ORM\ManyToMany(targetEntity: Tuteur::class, inversedBy: 'enfants')]
    private Collection $parents;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $photo = null;

    #[ORM\Column(length: 10)]
    private ?string $sexe = null;


    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateDeNaissance = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $observations = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $personneAContacter1 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $personneAContacter2 = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $numeroContact1 = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $numeroContact2 = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateDInscription = null;

    #[ORM\Column(nullable: true)]
    private ?bool $inscriptionComplete = null;

    #[ORM\ManyToOne(inversedBy: 'eleves')]
    private ?ClasseAnneeScolaire $classeActuelle = null;

    /**
     * @var Collection<int, Inscription>
     */
    #[ORM\OneToMany(targetEntity: Inscription::class, mappedBy: 'eleve')]
    private Collection $inscriptions;

    #[ORM\Column(nullable: true)]
    private ?bool $exemption = null;

    #[ORM\ManyToOne(inversedBy: 'eleves')]
    private ?Ecole $ecole = null;

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


    public function getLastInscription(): ?Inscription
    {
        return ($this->inscriptions->last()) ? $this->inscriptions->last() : null;

    }

    public function getImpayes(): array
    {

        $impayes = [];

        foreach ($this->inscriptions as $inscription) {
            if ($inscription->getMontantRestant() != 0 && !$inscription->getClasse()->isActive()) {
                $impayes[] = $inscription;
            }
        }

        return ($impayes);
    }


    public function getMontantImpayes(): int
    {
        $impayes = $this->getImpayes();
        $montant = 0;
        foreach ($impayes as $impaye) {
            $montant = $montant + $impaye->getMontantRestant();
        }

        return $montant;
    }

    public function getDateDeNaissance(): ?\DateTimeInterface
    {
        return $this->dateDeNaissance;
    }

    public function setDateDeNaissance(?\DateTimeInterface $dateDeNaissance): static
    {
        $this->dateDeNaissance = $dateDeNaissance;

        return $this;
    }

    public function getObservations(): ?string
    {
        return $this->observations;
    }

    public function setObservations(?string $observations): static
    {
        $this->observations = $observations;

        return $this;
    }

    public function getPersonneAContacter1(): ?string
    {
        return $this->personneAContacter1;
    }

    public function setPersonneAContacter1(?string $personneAContacter1): static
    {
        $this->personneAContacter1 = $personneAContacter1;

        return $this;
    }

    public function getPersonneAContacter2(): ?string
    {
        return $this->personneAContacter2;
    }

    public function setPersonneAContacter2(?string $personneAContacter2): static
    {
        $this->personneAContacter2 = $personneAContacter2;

        return $this;
    }

    public function getNumeroContact1(): ?string
    {
        return $this->numeroContact1;
    }

    public function setNumeroContact1(?string $numeroContact1): static
    {
        $this->numeroContact1 = $numeroContact1;

        return $this;
    }

    public function getNumeroContact2(): ?string
    {
        return $this->numeroContact2;
    }

    public function setNumeroContact2(?string $numeroContact2): static
    {
        $this->numeroContact2 = $numeroContact2;

        return $this;
    }

    public function getDateDInscription(): ?\DateTimeInterface
    {
        return $this->dateDInscription;
    }

    public function setDateDInscription(?\DateTimeInterface $dateDInscription): static
    {
        $this->dateDInscription = $dateDInscription;

        return $this;
    }

    public function isInscriptionComplete(): ?bool
    {
        return $this->inscriptionComplete;
    }

    public function setInscriptionComplete(?bool $inscriptionComplete): static
    {
        $this->inscriptionComplete = $inscriptionComplete;

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

    public function isExemption(): ?bool
    {
        return $this->exemption;
    }

    public function setExemption(?bool $exemption): static
    {
        $this->exemption = $exemption;

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
