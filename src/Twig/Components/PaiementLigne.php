<?php

namespace App\Twig\Components;

use App\Entity\Paiement;
use App\Form\DynamicPaiementType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\ComponentWithFormTrait;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\Component\Form\FormInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\UX\LiveComponent\Attribute\LiveAction;

#[AsLiveComponent()]
class PaiementLigne extends AbstractController
{
    use DefaultActionTrait;

    #[LiveProp]
    public ?Paiement $paiement = null;


}
