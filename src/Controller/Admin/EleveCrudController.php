<?php

namespace App\Controller\Admin;

use App\Entity\AnneeScolaire;
use App\Entity\Eleve;
use App\Entity\Inscription;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\RedirectResponse;

class EleveCrudController extends AbstractCrudController
{
    private $adminUrlGenerator;

    public function __construct(AdminUrlGenerator $adminUrlGenerator)
    {
        $this->adminUrlGenerator = $adminUrlGenerator;
    }

    public static function getEntityFqcn(): string
    {
        return Eleve::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            FormField::addTab("Informations de l'élève "),
            ImageField::new('photo')->setBasePath('public/élèves/photos/')->setUploadDir('public/élèves/photos/')->setFormTypeOptions(['attr' => [
                'accept' => 'image/*',
            ],
            ]),
            TextField::new('matricule'),
            TextField::new('nom'),
            TextField::new('prenoms'),
            ChoiceField::new('sexe')->setChoices([
                'M' => 'masculin',
                'F' => 'feminin',
            ]),
            TextField::new('lieuDeNaissance')->setLabel('Lieu de naissance'),
            TextField::new('nationalite')->setLabel('Nationalité'),
            DateField::new('dateDeNaissance')->setLabel('Date de naissance'),
            DateField::new('dateDInscription')->setLabel("Date d'inscription"),
            TextField::new('ecoleDeProvenance')->setLabel('Ecole de provenance'),
            AssociationField::new('classeActuelle'),
            //CollectionField::new('inscriptions')->useEntryCrudForm(),

            //FormField::addTab('Parents'),
            //CollectionField::new('parents')->allowAdd(true)->useEntryCrudForm()->setEntryIsComplex(),
        ];
    }

    /*public function createEntity(string $entityFqcn)
    {
        $eleve = new Eleve();
        $inscription = new Inscription();

       // $entityManager = $this->getDoctrine()->getManager();
        $entityManager = $this->container->get('doctrine')->getManager();
        $entityManager->persist($inscription);

        $eleve->addInscription($inscription);

        return $eleve;
    }*/

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
            //$this->addFlash('notice', 'La fin ne peut pas etre inférieure au début');
            // let him take the natural course
            parent::persistEntity($entityManager, $entityInstance);
            $this->createInscription($entityManager, $entityInstance);

    }

    public function createInscription(EntityManagerInterface $entityManager,Eleve $eleve){

        $schoolYearRepository = $entityManager->getRepository(AnneeScolaire::class);

        $inscription = new Inscription();
        $inscription->setEleve($eleve);
        $inscription->setClasse($eleve->getClasseActuelle());

        $eleve->addInscription($inscription);

        parent::persistEntity($entityManager, $inscription);


    }

    protected function getRedirectResponseAfterSave(AdminContext $context, string $action): RedirectResponse
    {
        $submitButtonName = $context->getRequest()->request->all()['ea']['newForm']['btn'];
    
        $url = $this->container->get(AdminUrlGenerator::class)
                ->setController(InscriptionCrudController::class)
                ->setAction(Action::EDIT)
                ->setEntityId($context->getEntity()->getInstance()->getLastInscription())
                ->generateUrl();

        return $this->redirect($url);
        
    
       // return parent::getRedirectResponseAfterSave($context, $action);
    }
    
}
