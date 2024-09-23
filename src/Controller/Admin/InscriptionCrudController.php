<?php

namespace App\Controller\Admin;

use App\Entity\Inscription;
use App\Form\PaiementType;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\BrowserKit\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

class InscriptionCrudController extends AbstractCrudController
{
    private $adminUrlGenerator;

    public function __construct(AdminUrlGenerator $adminUrlGenerator)
    {
        $this->adminUrlGenerator = $adminUrlGenerator;
    }

    public static function getEntityFqcn(): string
    {
        return Inscription::class;
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        //$this->addFlash('notice', 'La fin ne peut pas etre inférieure au début');
        // let him take the natural course
        $entityInstance->setPaiementUnique(false);

        parent::persistEntity($entityManager, $entityInstance);

    }


    public function configureFields(string $pageName): iterable
    {
        $eleve = AssociationField::new('eleve');
        $classe = AssociationField::new('Classe');
        $montantDeBase = MoneyField::new('MontantDeBase')->setCurrency('XAF')->setNumDecimals(0)->setStoredAsCents(false);
        $statusPaiement = TextField::new('StatusPaiement');
        $totalAPayer = MoneyField::new('TotalAPayer')->setCurrency('XAF')->setNumDecimals(0)->setStoredAsCents(false);
        $totalDesRemises = MoneyField::new('TotalDesRemises')->setCurrency('XAF')->setNumDecimals(0)->setStoredAsCents(false);
        $montantRestant = MoneyField::new('montantRestant')->setCurrency('XAF')->setNumDecimals(0)->setStoredAsCents(false);
        $totalRemis = MoneyField::new('TotalRemis')->setCurrency('XAF')->setNumDecimals(0)->setStoredAsCents(false);
        $montantDeLaRemise = MoneyField::new('MontantDeLaRemise')->setCurrency('XAF')->setNumDecimals(0)->setStoredAsCents(false);
        $montantPourRemiseUnique = MoneyField::new('MontantPourRemiseUnique')->setCurrency('XAF')->setNumDecimals(0)->setStoredAsCents(false);
        $remise = AssociationField::new('remise');
        $paiementUnique = BooleanField::new('paiementUnique')->setFormTypeOption('disabled', 'disabled');
        $paiements = CollectionField::new('paiements')->allowAdd(false);


        if (Crud::PAGE_INDEX === $pageName) {
            return [
            $eleve,
            $classe,
            $remise,
            $totalAPayer->hideOnIndex(),
            $montantDeBase->hideOnIndex(),
            $statusPaiement,
            $paiementUnique->hideOnIndex(),
            $paiements];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
            return [
                $eleve,
                $classe,
                $remise,
                $totalAPayer,
                $montantDeBase,
                $statusPaiement,
                $paiementUnique,
                $paiements
            ];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [
                $eleve->setFormTypeOption('disabled', 'disabled'),
                $classe,
                $remise,
                $totalAPayer->setFormTypeOption('disabled', 'disabled'),
                $montantDeBase->setFormTypeOption('disabled', 'disabled'),
                $statusPaiement->setFormTypeOption('disabled', 'disabled'),
                $paiementUnique->setFormTypeOption('disabled', 'disabled'),
                $paiements
            ];
        } else {
            return [$eleve, $classe, $remise];
        }


        /*return [
            $eleve->setFormTypeOption('disabled','disabled'),
            $classe ->setFormTypeOption('disabled','disabled'),
            MoneyField::new('MontantDeBase')->hideOnForm()->setCurrency('XAF')->setNumDecimals(0)->setStoredAsCents(false)
            ->hideWhenCreating()->setFormTypeOption('disabled','disabled')->hideOnIndex(),
            MoneyField::new('TotalAPayer')->setCurrency('XAF')->setNumDecimals(0)->setStoredAsCents(false)
                ->hideWhenCreating()->setFormTypeOption('disabled','disabled')->hideOnIndex(),
            TextField::new('StatusPaiement')->hideOnForm(),
            /*MoneyField::new('TotalDesRemises')->hideOnForm()->setCurrency('XAF')->setNumDecimals(0)->setStoredAsCents(false)
            ->hideWhenCreating()->setFormTypeOption('disabled','disabled')->hideOnIndex(),

            MoneyField::new('montantRestant')->setCurrency('XAF')->setNumDecimals(0)->setStoredAsCents(false)
                ->hideWhenCreating()->setFormTypeOption('disabled','disabled')->hideOnIndex(),

            /*MoneyField::new('TotalRemis')->setCurrency('XAF')->setNumDecimals(0)->setStoredAsCents(false)
                ->hideWhenCreating()->setFormTypeOption('disabled','disabled')->hideOnIndex(),

                            MoneyField::new('MontantDeLaRemise')->hideOnForm()->setCurrency('XAF')->setNumDecimals(0)->setStoredAsCents(false)
            ->hideWhenCreating()->setFormTypeOption('disabled','disabled')->hideOnIndex(),



            MoneyField::new('MontantPourRemiseUnique')->setCurrency('XAF')->setNumDecimals(0)->setStoredAsCents(false)
                ->hideWhenCreating()->setFormTypeOption('disabled','disabled')->hideOnIndex(),

            AssociationField::new('remise'),
            BooleanField::new('paiementUnique')->setFormTypeOption('disabled','disabled'),
            CollectionField::new('paiements')->useEntryCrudForm()->allowAdd(false)->setEntryIsComplex()->hideWhenCreating(),

        ];*/
    }

    public function ajouterTranche(
        AdminContext $context,
        AdminUrlGenerator $adminUrlGenerator,
        EntityManagerInterface $em
    ) {
        /** @var Inscription $inscription */
        $inscription = $context->getEntity()->getInstance();


        $url = $adminUrlGenerator
            ->setController(PaiementCrudController::class)
            ->setAction(Action::NEW)
            ->set('inscription', $inscription->getId())
            ->unset('entityId')
            ->generateUrl();

        return $this->redirect($url);
    }


    public function configureActions(Actions $actions): Actions
    {

        $paiementAction =    Action::new('nouveauPaiement', 'Nouveau paiement')
        ->linkToCrudAction('ajouterTranche')
        ->displayIf(static function ($inscription) {
            return $inscription->getMontantRestant() != 0;
        });

        return $actions
        ->add(Crud::PAGE_INDEX, Action::DETAIL)
        ->add(Crud::PAGE_EDIT, $paiementAction)
        ->add(Crud::PAGE_INDEX, $paiementAction)
            ->update(Crud::PAGE_NEW, Action::SAVE_AND_RETURN, function (Action $action) {
                return $action->setLabel('Enregistrer');
            })
            ->update(Crud::PAGE_NEW, Action::SAVE_AND_ADD_ANOTHER, function (Action $action) {
                return $action->setLabel('Enregistrer et ajouter un autre');
            });
        //->remove(Crud::PAGE_INDEX, Action::NEW)
        //  ->remove(Crud::PAGE_INDEX, Action::DELETE)
        ;

    }

    /*public function configureCrud(Crud $crud): Crud
    {
        return $crud
            // ...
            ->showEntityActionsInlined()
        ;
    }*/

    /*protected function getRedirectResponseAfterSave(AdminContext $context, string $action): RedirectResponse
    {
        //$submitButtonName = $context->getRequest()->request->all()['ea']['newForm']['btn'];

        $url = $this->container->get(AdminUrlGenerator::class)
                ->setController(EleveCrudController::class)
                ->setAction(Action::INDEX)
                ->generateUrl();

        return $this->redirect($url);


       // return parent::getRedirectResponseAfterSave($context, $action);
    }*/

}
