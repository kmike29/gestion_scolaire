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
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\BrowserKit\Response;

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
            MoneyField::new('montantRestant')->setCurrency('XAF')->setNumDecimals(0)->setStoredAsCents(false),
            MoneyField::new('TotalRemis')->setCurrency('XAF')->setNumDecimals(0)->setStoredAsCents(false),
            CollectionField::new('paiements')->useEntryCrudForm()->allowAdd(true)->setEntryIsComplex(),

        ];
    }

    public function duplicateProduct(
        AdminContext $context,
        AdminUrlGenerator $adminUrlGenerator,
        EntityManagerInterface $em
    ){
        /** @var Product $product */
        $inscription = $context->getEntity()->getInstance();


        $url = $adminUrlGenerator            
            ->setController(PaiementCrudController::class)
            ->setAction(Action::NEW)
            ->set('idInscription',$inscription->getId())
            ->generateUrl();

        return $this->redirect($url);
    }

    public function configureActions(Actions $actions): Actions
    {

        /*$url = $this->adminUrlGenerator
            ->setDashboard(DashboardController::class)
            ->setController(PaiementCrudController::class)
            ->setAction(Action::NEW)
            ->set('inscriptionId',function (Inscription $inscription): array {
                return [
                    'iDinscription' => $inscription->getId(),
                ];
            })
            ->generateUrl();*/

         $paiementAction =    Action::new('nouveauPaiement', 'Nouveau paiement')
         ->linkToCrudAction('duplicateProduct')        
         ->displayIf(static function ($inscription) {
            return $inscription->getMontantRestant()!=0;
        }); 


        /*$paiementAction = Action::new('nouveauPaiement', 'Nouveau paiement')
        ->displayAsLink()
        ->displayIf(static function ($inscription) {
            return $inscription->getMontantRestant()!=0;
        })
        ->linkToRoute('app_paiement_new', function (Inscription $inscription): array {
            return [
                'iDinscription' => $inscription->getId(),
            ];
        });*/

        return $actions
        ->add(Crud::PAGE_EDIT , $paiementAction)
        ->add(Crud::PAGE_INDEX , $paiementAction)
        /*->add(Crud::PAGE_INDEX, 
                  Action::new('add-second-entity', 'Add second entity')
                ->linkToUrl($url)
            )*/
        ->remove(Crud::PAGE_INDEX, Action::NEW)
        ->remove(Crud::PAGE_INDEX, Action::DELETE)
        ;
        
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            // ...
            ->showEntityActionsInlined()
        ;
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        
    }
    
}
