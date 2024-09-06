<?php

// src/Twig/Components/ProductSearch.php

namespace App\Twig\Components;

use App\Repository\EleveRepository;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveArg;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\LiveComponent\ComponentToolsTrait;
use App\Entity\Eleve;

#[AsLiveComponent]
class RechercheEleve
{
    use DefaultActionTrait;
    use ComponentToolsTrait;

    #[LiveProp(writable: true)]
    public string $query = '';

    #[LiveProp(writable: true)]
    /** @var Eleve[] */
    public $value  = [];

    public function __construct(private EleveRepository $eleveRepository)
    {
    }

    public function getResultats(): array
    {
        // example method that returns an array of Products
        return ($this->query!='') ?  $this->eleveRepository->search($this->query) : [];
    }

    #[LiveAction]
    public function addStudent(#[LiveArg] int $id)
    {
        $eleve = $this->eleveRepository->findOneBy(['id' => $id]);
        //$this->current = $eleve;
        $this->value[] = $eleve;
        $this->query = '';
        $this->emitUp('addStudent', $this->value);
    }
}
