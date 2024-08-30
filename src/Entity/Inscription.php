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

    #[ORM\ManyToOne(inversedBy: 'inscriptions')]
    private ?Remise $remise = null;

    #[ORM\Column]
    private ?bool $paiementUnique = null;



    public function __construct()
    {
        $this->paiements = new ArrayCollection();
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

    public function getMontantDeBase() : int {
        return $this->getClasse()->getFraisScolarite();
    }

    
    public function getFraisInscription() : int {
        return $this->getClasse()->getFraisInscription();
    }


    public function getTotalAPayer(): int
    {
        return $this->getMontantDeBase() - $this->getMontantDeLaRemise();
    }

    public function getMontantDeLaRemise(): int
    {
        $base = $this->getMontantDeBase();
        $remise = ($this->remise) ?  ($base * $this->getRemise()->getPourcentage())/100 : 0;
    
        return  $remise;
    }

    public function getTotalDesRemises(): int 
    {
        return ($this->isPaiementUnique())?  $this->getMontantDeBase() - $this->getTotalRemis() : $this->getMontantDeBase() - $this->getTotalAPayer()  ;
    }

    public function getMontantPourRemiseUnique(): int
    {
        return $this->getTotalAPayer() * 0.9;
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
        return ($this->isPaiementUnique()) ?  0 : $this->getTotalAPayer() - $this->getTotalRemis()  ;
    }

    public function __toString(): string
    {
        // return strval('('.$this->getClasse().') élève:  '.$this->getEleve());
         return strval($this->getEleve());


    }

    public function getRemise(): ?Remise
    {
        return $this->remise;
    }

    public function setRemise(?Remise $remise): static
    {
        $this->remise = $remise;

        return $this;
    }

    public function isPaiementUnique(): ?bool
    {
        return $this->paiementUnique;
    }

    public function setPaiementUnique(bool $paiementUnique): static
    {
        $this->paiementUnique = $paiementUnique;

        return $this;
    }

    public function getStatusPaiement() : string   
    {
        $status = '';
        if($this->isPaiementUnique()){
            $status =  strval($this->getTotalRemis()). ' FCFA payés; sur '.strval($this->getTotalAPayer()) . ' FCFA (remise pour paiement en 1 tranche) ' ;

        }else{
            $status =  strval($this->getTotalRemis()). ' FCFA payés sur '.strval($this->getTotalAPayer()) . ' FCFA' ;
        }
        
        return $status; 
    }




}
