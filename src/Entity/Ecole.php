<?php

namespace App\Entity;

use App\Repository\EcoleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EcoleRepository::class)]
class Ecole
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $nom = null;

    #[ORM\Column(length: 150, nullable: true)]
    private ?string $adresse = null;

    #[ORM\Column(length: 50)]
    private ?string $contact = null;

    /**
     * @var Collection<int, Eleve>
     */
    #[ORM\OneToMany(targetEntity: Eleve::class, mappedBy: 'ecole')]
    private Collection $eleves;

    /**
     * @var Collection<int, ClasseAnneeScolaire>
     */
    #[ORM\OneToMany(targetEntity: ClasseAnneeScolaire::class, mappedBy: 'ecole')]
    private Collection $classesEcole;

    /**
     * @var Collection<int, Classe>
     */
    #[ORM\OneToMany(targetEntity: Classe::class, mappedBy: 'ecole')]
    private Collection $classesDeBase;

    /**
     * @var Collection<int, Facture>
     */
    #[ORM\OneToMany(targetEntity: Facture::class, mappedBy: 'ecole')]
    private Collection $factures;

    /**
     * @var Collection<int, Inscription>
     */
    #[ORM\OneToMany(targetEntity: Inscription::class, mappedBy: 'ecole')]
    private Collection $inscriptions;

    /**
     * @var Collection<int, Personnel>
     */
    #[ORM\ManyToMany(targetEntity: Personnel::class, inversedBy: 'ecoles')]
    private Collection $personnel;

    public function __construct()
    {
        $this->eleves = new ArrayCollection();
        $this->classesEcole = new ArrayCollection();
        $this->classesDeBase = new ArrayCollection();
        $this->factures = new ArrayCollection();
        $this->inscriptions = new ArrayCollection();
        $this->personnel = new ArrayCollection();
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

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(?string $adresse): static
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getContact(): ?string
    {
        return $this->contact;
    }

    public function setContact(string $contact): static
    {
        $this->contact = $contact;

        return $this;
    }

    /**
     * @return Collection<int, Eleve>
     */
    public function getEleves(): Collection
    {
        return $this->eleves;
    }

    public function addElefe(Eleve $elefe): static
    {
        if (!$this->eleves->contains($elefe)) {
            $this->eleves->add($elefe);
            $elefe->setEcole($this);
        }

        return $this;
    }

    public function removeElefe(Eleve $elefe): static
    {
        if ($this->eleves->removeElement($elefe)) {
            // set the owning side to null (unless already changed)
            if ($elefe->getEcole() === $this) {
                $elefe->setEcole(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ClasseAnneeScolaire>
     */
    public function getClassesEcole(): Collection
    {
        return $this->classesEcole;
    }

    public function addClassesEcole(ClasseAnneeScolaire $classesEcole): static
    {
        if (!$this->classesEcole->contains($classesEcole)) {
            $this->classesEcole->add($classesEcole);
            $classesEcole->setEcole($this);
        }

        return $this;
    }

    public function removeClassesEcole(ClasseAnneeScolaire $classesEcole): static
    {
        if ($this->classesEcole->removeElement($classesEcole)) {
            // set the owning side to null (unless already changed)
            if ($classesEcole->getEcole() === $this) {
                $classesEcole->setEcole(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Classe>
     */
    public function getClassesDeBase(): Collection
    {
        return $this->classesDeBase;
    }

    public function addClassesDeBase(Classe $classesDeBase): static
    {
        if (!$this->classesDeBase->contains($classesDeBase)) {
            $this->classesDeBase->add($classesDeBase);
            $classesDeBase->setEcole($this);
        }

        return $this;
    }

    public function removeClassesDeBase(Classe $classesDeBase): static
    {
        if ($this->classesDeBase->removeElement($classesDeBase)) {
            // set the owning side to null (unless already changed)
            if ($classesDeBase->getEcole() === $this) {
                $classesDeBase->setEcole(null);
            }
        }

        return $this;
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
            $facture->setEcole($this);
        }

        return $this;
    }

    public function removeFacture(Facture $facture): static
    {
        if ($this->factures->removeElement($facture)) {
            // set the owning side to null (unless already changed)
            if ($facture->getEcole() === $this) {
                $facture->setEcole(null);
            }
        }

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
            $inscription->setEcole($this);
        }

        return $this;
    }

    public function removeInscription(Inscription $inscription): static
    {
        if ($this->inscriptions->removeElement($inscription)) {
            // set the owning side to null (unless already changed)
            if ($inscription->getEcole() === $this) {
                $inscription->setEcole(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Personnel>
     */
    public function getPersonnel(): Collection
    {
        return $this->personnel;
    }

    public function addPersonnel(Personnel $personnel): static
    {
        if (!$this->personnel->contains($personnel)) {
            $this->personnel->add($personnel);
        }

        return $this;
    }

    public function removePersonnel(Personnel $personnel): static
    {
        $this->personnel->removeElement($personnel);

        return $this;
    }
}
