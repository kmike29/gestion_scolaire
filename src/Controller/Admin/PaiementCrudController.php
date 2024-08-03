<?php

namespace App\Controller\Admin;

use App\Entity\Inscription;
use App\Entity\Paiement;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;

class PaiementCrudController extends AbstractCrudController
{
    private $adminUrlGenerator;

    public function __construct(AdminUrlGenerator $adminUrlGenerator)
    {
        $this->adminUrlGenerator = $adminUrlGenerator;
    }



    public static function getEntityFqcn(): string
    {
        return Paiement::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            ChoiceField::new('type')->setChoices([
                'tranche' => 'tranche',
            ]),
            MoneyField::new('montant')->setCurrency('XAF')->setNumDecimals(0)->setStoredAsCents(false),
        ];
    }

    public function createEntity(string $entityFqcn)
    {
        $paiement = new Paiement();

        $inscriptionRepository = $this->container->get('doctrine')->getManager()->getRepository(Inscription::class);
        $inscription = $inscriptionRepository->findOneBy(['id' => $this->adminUrlGenerator->get('inscription')]);
        dump($inscription);

        $paiement->setInscription($inscription);
        return $paiement;
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
            //$this->addFlash('notice', 'Paiement unique');
            // let him take the natural course
            $inscription = $entityInstance->getInscription();

            if($inscription->getPaiements()->isEmpty() && $inscription->getMontantPourRemiseUnique()<=$entityInstance->getMontant() ){
                $inscription->setPaiementUnique(true);
                parent::persistEntity($entityManager, $inscription);
                $this->addFlash('notice', 'Paiement unique');
            }


            parent::persistEntity($entityManager, $entityInstance);

    }



   /* public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
            //$this->addFlash('notice', 'La fin ne peut pas etre inférieure au début');
            // let him take the natural course
            $inscription = $entityInstance
            parent::persistEntity($entityManager, $entityInstance);

    }*/
}
