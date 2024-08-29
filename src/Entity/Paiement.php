<?php

namespace App\Entity;

use App\Repository\PaiementRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PaiementRepository::class)]
class Paiement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 20)]
    private ?string $type = null;

    #[ORM\Column]
    private ?int $montant = null;

    #[ORM\ManyToOne(inversedBy: 'paiements')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Inscription $inscription = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateDeTransaction = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getMontant(): ?int
    {
        return $this->montant;
    }

    public function setMontant(int $montant): static
    {
        $this->montant = $montant;

        return $this;
    }

    public function getInscription(): ?Inscription
    {
        return $this->inscription;
    }

    public function setInscription(?Inscription $inscription): static
    {
        $this->inscription = $inscription;

        return $this;
    }

    public function getEleve() : string
    {
        return ($this->getInscription())? $this->getInscription()->getEleve()->__toString() : '';
    }

    public function getClasse() : string 
    {
        return ($this->getInscription())?  $this->getInscription()->getClasse()->__toString() : '';

    }

    public function getMontantRestant() : int
    {
        return ($this->getInscription())?  $this->getInscription()->getMontantRestant() : 0 ;
    }

    
    public function getTotalRemis() : int
    {
        return  ($this->getInscription())?  $this->getInscription()->getTotalRemis() :0;
    }

        
    public function getTotalAPayer() : int
    {
        return ($this->getInscription())?  $this->getInscription()->getTotalAPayer() : 0;
    }

            
    public function getMontantPourPayementUnique() : int
    {
        return ($this->getInscription())?  $this->getInscription()->getMontantPourRemiseUnique() : 0;
    }


    public function getStatusPaiement() : string   
    {
        return ($this->getInscription())?  strval($this->getTotalRemis()). ' FCFA payés / '.strval($this->getTotalAPayer()) . ' FCFA'  : "Pas d'inscription choisi"; 
    }

    public function __toString()
    {
        return strval('Paiement de ' . $this->getMontant());
    }

    public function getDateDeTransaction(): ?\DateTimeInterface
    {
        return $this->dateDeTransaction;
    }

    public function setDateDeTransaction(?\DateTimeInterface $dateDeTransaction): static
    {
        $this->dateDeTransaction = $dateDeTransaction;

        return $this;
    }
}
