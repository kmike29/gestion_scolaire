<?php

namespace App\Twig\Components;

use App\Entity\Paiement;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent()]
class EncaisseurLigne extends AbstractController
{
    // use ComponentWithFormTrait;
    use DefaultActionTrait;

    #[LiveProp]
    public ?Paiement $paiement = null;





}
