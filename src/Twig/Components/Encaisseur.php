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

#[AsLiveComponent()]
class Encaisseur extends AbstractController
{
    use ComponentWithFormTrait;
    use DefaultActionTrait;

    #[LiveProp]
    public ?Paiement $initialFormData = null;

    protected function instantiateForm(): FormInterface
    {
        return $this->createForm(DynamicPaiementType::class, $this->initialFormData);
    }
}