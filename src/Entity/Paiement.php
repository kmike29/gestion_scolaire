<?php

namespace App\Entity;

use App\Repository\PaiementRepository;
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
        return $this->getInscription()->getEleve()->__toString();
    }

    public function getClasse() : string 
    {
        return $this->getInscription()->getClasse()->__toString();

    }

    public function getMontantRestant() : int
    {
        return  $this->getInscription()->getMontantRestant();
    }

    
    public function getTotalRemis() : int
    {
        return  $this->getInscription()->getTotalRemis();
    }

        
    public function getTotalAPayer() : int
    {
        return  $this->getInscription()->getTotalAPayer();
    }

            
    public function getMontantPourPayementUnique() : int
    {
        return  $this->getInscription()->getMontantPourRemiseUnique();
    }


    public function getStatusPaiement() : string   
    {
        return strval($this->getTotalRemis()). ' FCFA payés / '.strval($this->getTotalAPayer()) . ' FCFA' ; 
    }
}
