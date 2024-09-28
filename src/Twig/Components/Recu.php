<?php

namespace App\Twig\Components;

use App\Entity\Paiement;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent()]
class Recu extends AbstractController
{
    use DefaultActionTrait;

    #[LiveProp]
    public ?Paiement $paiement = null;


}
