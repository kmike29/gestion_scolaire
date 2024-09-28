<?php

namespace App\Entity;

use App\Repository\ClasseAnneeScolaireRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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

    /**
     * @var Collection<int, Inscription>
     */
    #[ORM\OneToMany(targetEntity: Inscription::class, mappedBy: 'Classe')]
    private Collection $inscriptions;

    #[Assert\Positive(message : 'Les frais doivent etre supérieur à 0')]
    #[ORM\Column]
    private ?int $fraisInscription = null;

    #[Assert\Positive(message : 'Les frais doivent etre supérieur à 0')]
    #[ORM\Column]
    private ?int $fraisScolarite = null;

    /**
     * @var Collection<int, Eleve>
     */
    #[ORM\OneToMany(targetEntity: Eleve::class, mappedBy: 'classeActuelle')]
    private Collection $eleves;

    #[ORM\ManyToOne(inversedBy: 'classesEcole')]
    private ?Ecole $ecole = null;

    public function __construct()
    {
        $this->professeurPrincipal = new ArrayCollection();
        $this->emploisDuTemps = new ArrayCollection();
        $this->inscriptions = new ArrayCollection();
        $this->eleves = new ArrayCollection();
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



    /**
     * @return Collection<int, Inscription>
     */
    public function getInscriptions(): Collection
    {
        return $this->inscriptions;
    }


    /**
     * @return Collection<int, Inscription>
     */
    public function getInscriptionsIncompletes(): Collection
    {
        $impayes = $this->inscriptions;

        foreach ($impayes as $inscription) {
            if ($inscription->getEleve()->isInscriptionComplete()) {
                $impayes->removeElement($inscription);
            }
        }

        return ($impayes);
    }


    /**
     * @return Collection<int, Inscription>
     */
    public function getScolaritésIncompletes(): Collection
    {
        $impayes = $this->inscriptions;

        foreach ($impayes as $inscription) {
            if ($inscription->getMontantRestant() == 0 && $inscription->getClasse()->getAnneeScolaire()->isActive()) {
                $impayes->removeElement($inscription);
            }
        }

        return ($impayes);
    }

    public function addInscription(Inscription $inscription): static
    {
        if (!$this->inscriptions->contains($inscription)) {
            $this->inscriptions->add($inscription);
            $inscription->setClasse($this);
        }

        return $this;
    }

    public function removeInscription(Inscription $inscription): static
    {
        if ($this->inscriptions->removeElement($inscription)) {
            // set the owning side to null (unless already changed)
            if ($inscription->getClasse() === $this) {
                $inscription->setClasse(null);
            }
        }

        return $this;
    }

    public function getFraisInscription(): ?int
    {
        return $this->fraisInscription;
    }

    public function setFraisInscription(int $fraisInscription): static
    {
        $this->fraisInscription = $fraisInscription;

        return $this;
    }

    public function getFraisScolarite(): ?int
    {
        return $this->fraisScolarite;
    }

    public function setFraisScolarite(int $fraisScolarite): static
    {
        $this->fraisScolarite = $fraisScolarite;

        return $this;
    }

    public function isActive(): bool
    {
        return $this->getAnneeScolaire()->isActive();
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
            $elefe->setClasseActuelle($this);
        }

        return $this;
    }

    public function removeElefe(Eleve $elefe): static
    {
        if ($this->eleves->removeElement($elefe)) {
            // set the owning side to null (unless already changed)
            if ($elefe->getClasseActuelle() === $this) {
                $elefe->setClasseActuelle(null);
            }
        }

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
