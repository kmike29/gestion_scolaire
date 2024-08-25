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

    
    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('Eleve'),
            AssociationField::new('Classe'),

            MoneyField::new('MontantDeBase')->hideOnForm()->setCurrency('XAF')->setNumDecimals(0)->setStoredAsCents(false)
            ->hideWhenCreating()->setFormTypeOption('disabled','disabled')->hideOnIndex(),
            MoneyField::new('TotalAPayer')->setCurrency('XAF')->setNumDecimals(0)->setStoredAsCents(false)
                ->hideWhenCreating()->setFormTypeOption('disabled','disabled')->hideOnIndex(),
                
            TextField::new('StatusPaiement')->hideOnForm(),

            /*MoneyField::new('TotalDesRemises')->hideOnForm()->setCurrency('XAF')->setNumDecimals(0)->setStoredAsCents(false)
            ->hideWhenCreating()->setFormTypeOption('disabled','disabled')->hideOnIndex(),*/

            MoneyField::new('montantRestant')->setCurrency('XAF')->setNumDecimals(0)->setStoredAsCents(false)
                ->hideWhenCreating()->setFormTypeOption('disabled','disabled')->hideOnIndex(),

            /*MoneyField::new('TotalRemis')->setCurrency('XAF')->setNumDecimals(0)->setStoredAsCents(false)
                ->hideWhenCreating()->setFormTypeOption('disabled','disabled')->hideOnIndex(),

                            MoneyField::new('MontantDeLaRemise')->hideOnForm()->setCurrency('XAF')->setNumDecimals(0)->setStoredAsCents(false)
            ->hideWhenCreating()->setFormTypeOption('disabled','disabled')->hideOnIndex(),
                
                */

            MoneyField::new('MontantPourRemiseUnique')->setCurrency('XAF')->setNumDecimals(0)->setStoredAsCents(false)
                ->hideWhenCreating()->setFormTypeOption('disabled','disabled')->hideOnIndex(),

            AssociationField::new('remise'),
            BooleanField::new('paiementUnique')->setFormTypeOption('disabled','disabled'),
            CollectionField::new('paiements')->useEntryCrudForm()->allowAdd(false)->setEntryIsComplex()->hideWhenCreating(),

        ];
    }

    public function ajouterTranche(
        AdminContext $context,
        AdminUrlGenerator $adminUrlGenerator,
        EntityManagerInterface $em
    ){
        /** @var Product $product */
        $inscription = $context->getEntity()->getInstance();


        $url = $adminUrlGenerator            
            ->setController(PaiementCrudController::class)
            ->setAction(Action::NEW)
            ->set('inscription',$inscription->getId())
            ->unset('entityId')
            ->generateUrl();

        return $this->redirect($url);
    }

    public function configureActions(Actions $actions): Actions
    {

         $paiementAction =    Action::new('nouveauPaiement', 'Nouveau paiement')
         ->linkToCrudAction('ajouterTranche')        
         ->displayIf(static function ($inscription) {
            return $inscription->getMontantRestant()!=0;
        }); 

        return $actions
        ->add(Crud::PAGE_INDEX , Action::DETAIL)
        ->add(Crud::PAGE_EDIT , $paiementAction)
        ->add(Crud::PAGE_INDEX , $paiementAction)
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
