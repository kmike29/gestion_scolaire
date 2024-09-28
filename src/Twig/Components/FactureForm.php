<?php

namespace App\Twig\Components;

use App\Entity\AnneeScolaire;
use App\Entity\Facture;
use App\Entity\Inscription;
use App\Entity\Paiement;
use App\Form\CollectionFactureType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\ComponentWithFormTrait;
use Symfony\UX\LiveComponent\DefaultActionTrait;
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
    public function save(EntityManagerInterface $entityManager): Response
    {
        $anneeScolaire = $this->getActiveAnneeScolaire($entityManager);
        $this->submitForm();

        /** @var Facture $facture */
        $facture = $this->getForm()->getData();
        $this->prepareFacture($facture, $anneeScolaire);

        foreach ($facture->getPaiements() as $paiement) {
            $this->preparePaiement($paiement, $entityManager);
        }

        $entityManager->persist($facture);
        $entityManager->flush();

        $this->addFlash('success', 'Paiement effectué!');
        return $this->redirectToRoute('admin', [
            'crudControllerFqcn' => 'App\Controller\Admin\PaiementCrudController',
            'crudAction' => 'index',
        ]);
    }

    private function getActiveAnneeScolaire(EntityManagerInterface $entityManager): ?AnneeScolaire
    {
        $anneeRepository = $entityManager->getRepository(AnneeScolaire::class);
        return $anneeRepository->findActiveYear(true);
    }

    private function prepareFacture(Facture $facture, AnneeScolaire $anneeScolaire): void
    {
        if (empty($facture->getReference())) {
            $facture->setReference($this->generateRandomString());
        }

        $facture->setDateFacture(new \DateTime());
        $facture->setAnneeScolaire($anneeScolaire);
    }

    private function preparePaiement(Paiement $paiement, EntityManagerInterface $entityManager): void
    {
        $paiement->setDateDeTransaction(new \DateTime());
        $inscription = $paiement->getInscription();
        $paiement->setType('scolarité');

        if ($this->isEligibleForUniquePayment($inscription, $paiement)) {
            $inscription->setPaiementUnique(true);
            $entityManager->persist($inscription);
            $this->addFlash('notice', 'Paiement unique');
        }
    }

    private function isEligibleForUniquePayment(Inscription$inscription, Paiement $paiement): bool
    {
        return $inscription->getPaiements()->isEmpty() && $inscription->getMontantPourRemiseUnique() <= $paiement->getMontant();
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
