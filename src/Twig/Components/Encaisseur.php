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

    #[LiveAction]
    public function save(EntityManagerInterface $entityManager)
    {
        // Submit the form! If validation fails, an exception is thrown
        // and the component is automatically re-rendered with the errors
        $this->submitForm();


        /** @var Paiement $paiement */
        $paiement = $this->getForm()->getData();
        //$paiement->setType('tranche');

        $paiement->setDateDeTransaction(new \DateTime());

        $inscription = $paiement->getInscription();
        $paiement->setType('scolarité');

        if($inscription->getPaiements()->isEmpty() && $inscription->getMontantPourRemiseUnique()<=$paiement->getMontant() ){
            $inscription->setPaiementUnique(true);
            $entityManager->persist($inscription);
            $this->addFlash('notice', 'Paiement unique');
        }

        if($paiement->getType()  =='inscription'){
            $paiement->setMontant($paiement->getInscription()->getFraisInscription());
            $eleve = $paiement->getInscription()->getEleve();
            $eleve->setInscriptionComplete(true);
            $entityManager->persist($eleve);
            $entityManager->flush();

        }


        $entityManager->persist($paiement);
        $entityManager->flush();

        

        $this->addFlash('success', 'Paiement effectué!');

        return $this->redirectToRoute('admin');
    }
}