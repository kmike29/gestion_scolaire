<?php

namespace App\Twig\Components;

use App\Entity\AnneeScolaire;
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
        $anneeRepository =  $entityManager->getRepository(AnneeScolaire::class);
        $anneeScolaire =  $anneeRepository->findActiveYear(true);


        $this->submitForm();

        /** @var Facture $facture */
        $facture = $this->getForm()->getData();

        if ($facture->getReference() == '' || $facture->getReference() == null) {
            $facture->setReference($this->generateRandomString());
        }
        $facture->setDateFacture(new \DateTime());
        $facture->setAnneeScolaire($anneeScolaire);

        foreach ($facture->getPaiements() as $paiement) {
            $paiement->setDateDeTransaction(new \DateTime());

            $inscription = $paiement->getInscription();
            $paiement->setType('scolarité');

            if ($inscription->getPaiements()->isEmpty() && $inscription->getMontantPourRemiseUnique() <= $paiement->getMontant()) {
                $inscription->setPaiementUnique(true);
                $entityManager->persist($inscription);
                $this->addFlash('notice', 'Paiement unique');
            }
        }

        $entityManager->persist($facture);
        $entityManager->flush();

        $this->addFlash('success', 'Paiement effectué!');

        return $this->redirectToRoute('admin');
    }

    public function generateRandomString($length = 7)
    {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }

        return $randomString;
    }
}
