<?php

namespace App\Twig\Components;

use App\Entity\Facture;
use App\Entity\Paiement;
use App\Form\CollectionFactureType;
use App\Form\DynamicPaiementType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\ComponentWithFormTrait;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\Component\Form\FormInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\LiveCollectionTrait;

#[AsLiveComponent()]
class FactureForm extends AbstractController
{
    use ComponentWithFormTrait;
    use LiveCollectionTrait;
    use DefaultActionTrait;

    #[LiveProp]
    public ?Facture $initialFormData = null;

    protected function instantiateForm(): FormInterface
    {
        return $this->createForm(CollectionFactureType::class, $this->initialFormData);
    }

    #[LiveAction]
    public function save(EntityManagerInterface $entityManager)
    {

        



        $this->addFlash('success', 'Paiement effectué!');

        return $this->redirectToRoute('admin');
    }
}
