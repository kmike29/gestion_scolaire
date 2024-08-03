<?php

namespace App\Entity;

use App\Repository\TypeRemiseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TypeRemiseRepository::class)]
class TypeRemise
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $designation = null;

    /**
     * @var Collection<int, Remise>
     */
    #[ORM\OneToMany(targetEntity: Remise::class, mappedBy: 'typeRemise')]
    private Collection $Remises;

    public function __construct()
    {
        $this->Remises = new ArrayCollection();
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

    /**
     * @return Collection<int, Remise>
     */
    public function getRemises(): Collection
    {
        return $this->Remises;
    }

    public function addRemise(Remise $remise): static
    {
        if (!$this->Remises->contains($remise)) {
            $this->Remises->add($remise);
            $remise->setTypeRemise($this);
        }

        return $this;
    }

    public function removeRemise(Remise $remise): static
    {
        if ($this->Remises->removeElement($remise)) {
            // set the owning side to null (unless already changed)
            if ($remise->getTypeRemise() === $this) {
                $remise->setTypeRemise(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->designation;
    }
}
