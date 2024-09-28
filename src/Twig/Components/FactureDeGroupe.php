<?php

namespace App\Twig\Components;

use App\Entity\Facture;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent()]
class FactureDeGroupe extends AbstractController
{
    use DefaultActionTrait;

    #[LiveProp]
    public ?Facture $facture = null;


}
