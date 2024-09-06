<?php

namespace App\Twig\Components;

use App\Entity\Eleve;
use App\Entity\Paiement;
use App\Form\DynamicPaiementType;
use App\Repository\EleveRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\ComponentWithFormTrait;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\Component\Form\FormInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveArg;
use Symfony\UX\LiveComponent\Attribute\LiveListener;
use Symfony\UX\LiveComponent\ComponentToolsTrait;

#[AsLiveComponent()]
class EncaisseurGroupe extends AbstractController
{
    use DefaultActionTrait;
    use ComponentToolsTrait;


    #[LiveProp(writable: true)]
    /** @var Paiement[] */
    public $paiements = [];


    #[LiveProp(writable: true)]
    /** @var Eleve[] */
    public $eleves = [];

    public function addStudentToList( Eleve $eleve,EleveRepository $eleveRepository)
    {
        //$eleve = $eleveRepository->findBy(['id' => $eleveId]);
       // dump($eleve);
        $this->paiements[] = $eleve;
    }
}
