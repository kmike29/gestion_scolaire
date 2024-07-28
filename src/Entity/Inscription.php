<?php

namespace App\Entity;

use App\Repository\InscriptionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InscriptionRepository::class)]
class Inscription
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'inscriptions')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Eleve $Eleve = null;

    #[ORM\ManyToOne(inversedBy: 'inscriptions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?ClasseAnneeScolaire $Classe = null;

    /**
     * @var Collection<int, Paiement>
     */
    #[ORM\OneToMany(targetEntity: Paiement::class, mappedBy: 'inscription')]
    private Collection $paiements;

    /**
     * @var Collection<int, Remise>
     */
    #[ORM\ManyToMany(targetEntity: Remise::class, mappedBy: 'inscriptions')]
    private Collection $remises;



    public function __construct()
    {
        $this->paiements = new ArrayCollection();
        $this->remises = new ArrayCollection();
    }

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

    public function getClasse(): ?ClasseAnneeScolaire
    {
        return $this->Classe;
    }

    public function setClasse(?ClasseAnneeScolaire $Classe): static
    {
        $this->Classe = $Classe;

        return $this;
    }

    /**
     * @return Collection<int, Paiement>
     */
    public function getPaiements(): Collection
    {
        return $this->paiements;
    }

    public function addPaiement(Paiement $paiement): static
    {
        if (!$this->paiements->contains($paiement)) {
            $this->paiements->add($paiement);
            $paiement->setInscription($this);
        }

        return $this;
    }

    public function removePaiement(Paiement $paiement): static
    {
        if ($this->paiements->removeElement($paiement)) {
            // set the owning side to null (unless already changed)
            if ($paiement->getInscription() === $this) {
                $paiement->setInscription(null);
            }
        }

        return $this;
    }

    public function getTotalRemis() : int 
    {
        $total = 0;

        if(!empty($this->paiements)){
            foreach ($this->paiements as $paiement) {
                $total += $paiement->getMontant();
            }
        }

        return $total;
    }

    public function getMontantRestant() : int
    {
        return $this->getClasse()->getFraisScolarite() - $this->getTotalRemis();
    }

    public function __toString(): string
    {
         return strval($this->getId());

    }

    /**
     * @return Collection<int, Remise>
     */
    public function getRemises(): Collection
    {
        return $this->remises;
    }

    public function addRemise(Remise $remise): static
    {
        if (!$this->remises->contains($remise)) {
            $this->remises->add($remise);
            $remise->addInscription($this);
        }

        return $this;
    }

    public function removeRemise(Remise $remise): static
    {
        if ($this->remises->removeElement($remise)) {
            $remise->removeInscription($this);
        }

        return $this;
    }


}
