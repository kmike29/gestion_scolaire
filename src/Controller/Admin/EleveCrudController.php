<?php

namespace App\Controller\Admin;

use App\Entity\AnneeScolaire;
use App\Entity\ClasseAnneeScolaire;
use App\Entity\Eleve;
use App\Entity\Inscription;
use App\Entity\Paiement;
use App\Repository\ClasseAnneeScolaireRepository;
use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder as ORMQueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
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

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('sexe')
            ->add('classeActuelle')

        ;
    }


    public function configureFields(string $pageName): iterable
    {



        return [
            FormField::addTab("Informations de l'élève "),
            ImageField::new('photo')->setBasePath('/élèves/photos/')->setUploadDir('public/élèves/photos/')->setFormTypeOptions(['attr' => [
                'accept' => 'image/*',
            ],
            ])->hideOnIndex(),
            TextField::new('matricule')->hideWhenCreating(),
            TextField::new('nom')->setColumns(6),
            TextField::new('prenoms')->setColumns(6),

            ChoiceField::new('sexe')->setChoices(['M' => 'masculin','F' => 'feminin', ])->renderExpanded()->setColumns(6) ,
            AssociationField::new('classeActuelle')->setColumns(6)
            ->setFormTypeOption('query_builder', function (ClasseAnneeScolaireRepository $entityRepository) {
                return $entityRepository->createQueryBuilder('t')
                ->innerJoin('t.anneeScolaire', 'c')
                ->andWhere('c.active = :actif')
                ->setParameter('actif', true);
            }),

            TextField::new('lieuDeNaissance')->setLabel('Lieu de naissance')->setColumns(6)->hideOnIndex(),
            TextField::new('nationalite')->setLabel('Nationalité')->setColumns(6)->hideOnIndex(),
            DateField::new('dateDeNaissance')->setLabel('Date de naissance')->setColumns(6)->hideOnIndex(),
            DateField::new('dateDInscription')->setLabel("Date d'inscription")->setColumns(6)->hideOnIndex()->hideWhenCreating(),


            FormField::addTab('Personnes à contacter'),

            TextField::new('personneAContacter1', 'Personne à contacter 1')->hideOnIndex(),
            TextField::new('numeroContact1', 'Numéro du contact 1')->hideOnIndex(),
            TextField::new('personneAContacter2', 'Personne à contacter 2')->hideOnIndex(),
            TextField::new('numeroContact2', 'Numéro contact 2')->hideOnIndex(),

            FormField::addTab('Paiemens & inscriptions')->hideWhenCreating(),
            MoneyField::new('MontantImpayes')->setCurrency('XOF')->setNumDecimals(0)->setStoredAsCents(false)->setFormTypeOption('disabled', 'disabled')->hideWhenCreating(),
            BooleanField::new('inscriptionComplete')->hideWhenCreating()->hideOnIndex(),
            CollectionField::new('inscriptions')->hideWhenCreating()->allowAdd(false),

            FormField::addTab('Informations complémentaires'),
            TextareaField::new('observations')->hideOnIndex(),
            TextField::new('ecoleDeProvenance')->setLabel('Ecole de provenance')->setColumns(6)->hideOnIndex(),

            //CollectionField::new('parents')->allowAdd(true)->useEntryCrudForm()->setEntryIsComplex(),
        ];
    }

    public function configureActions(Actions $actions): Actions
    {

        return $actions
        ->add(Crud::PAGE_INDEX, Action::DETAIL)
        //->remove(Crud::PAGE_INDEX, Action::NEW)
      //  ->remove(Crud::PAGE_INDEX, Action::DELETE)
        ;

    }


    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        //$this->addFlash('notice', 'La fin ne peut pas etre inférieure au début');
        // let him take the natural course
        $entityInstance->setInscriptionComplete(false);
        $entityInstance->setDateDInscription(new \DateTime());

        parent::persistEntity($entityManager, $entityInstance);
        $this->createInscription($entityManager, $entityInstance);
        parent::persistEntity($entityManager, $entityInstance);

    }

    public function createInscription(EntityManagerInterface $entityManager, Eleve $eleve)
    {


        $inscription = new Inscription();
        $inscription->setEleve($eleve);
        $inscription->setClasse($eleve->getClasseActuelle());
        $inscription->setPaiementUnique(false);
        $eleve->addInscription($inscription);
        parent::persistEntity($entityManager, $inscription);


        $paiement = new Paiement();
        $paiement->setType('inscription');
        $paiement->setMontant($inscription->getFraisInscription());
        $paiement->setInscription($inscription);
        $paiement->setDateDeTransaction(new \DateTime());

        parent::persistEntity($entityManager, $paiement);


    }

    protected function getRedirectResponseAfterSave(AdminContext $context, string $action): RedirectResponse
    {
        //$submitButtonName = $context->getRequest()->request->all()['ea']['newForm']['btn'];

        $url = $this->container->get(AdminUrlGenerator::class)
                ->setController(InscriptionCrudController::class)
                ->setAction(Action::EDIT)
                ->setEntityId($context->getEntity()->getInstance()->getLastInscription()->getId())
                ->generateUrl();

        return $this->redirect($url);

    }

}
