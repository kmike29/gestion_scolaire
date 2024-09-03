<?php

namespace App\Entity;

use App\Repository\RemiseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: RemiseRepository::class)]
class Remise
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\Length(
        min: 2,
        max: 100,
        minMessage: 'La designation doit contenir au moins {{ limit }} lettres',
        maxMessage: 'La designation ne doit pas contenir plus de {{ limit }} ',
    )]
    #[Assert\NoSuspiciousCharacters]
    #[ORM\Column(length: 100)]
    private ?string $designation = null;

    #[Assert\Positive(message : 'Les frais doivent etre supérieur à 0')]
    #[ORM\Column]
    private ?int $pourcentage = null;


    #[ORM\ManyToOne(inversedBy: 'Remises')]
    private ?TypeRemise $typeRemise = null;

    /**
     * @var Collection<int, Inscription>
     */
    #[ORM\OneToMany(targetEntity: Inscription::class, mappedBy: 'remise')]
    private Collection $inscriptions;



    public function __construct()
    {
        $this->inscriptions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDesignation(): ?string
    {
        return $this->designation;
    }

    public function setDesignation(string $designation): static
    {
        $this->designation = $designation;

        return $this;
    }

    public function getPourcentage(): ?int
    {
        return $this->pourcentage;
    }

    public function setPourcentage(int $pourcentage): static
    {
        $this->pourcentage = $pourcentage;

        return $this;
    }


    public function __toString(): string
    {
        return $this->designation.' ('.strval($this->pourcentage).' %)';
    }

    public function getTypeRemise(): ?TypeRemise
    {
        return $this->typeRemise;
    }

    public function setTypeRemise(?TypeRemise $typeRemise): static
    {
        $this->typeRemise = $typeRemise;

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
            $inscription->setRemise($this);
        }

        return $this;
    }

    public function removeInscription(Inscription $inscription): static
    {
        if ($this->inscriptions->removeElement($inscription)) {
            // set the owning side to null (unless already changed)
            if ($inscription->getRemise() === $this) {
                $inscription->setRemise(null);
            }
        }

        return $this;
    }



}
