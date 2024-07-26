<?php

namespace App\Controller\Admin;

use App\Entity\AnneeScolaire;
use App\Entity\Eleve;
use App\Entity\Inscription;
use Doctrine\ORM\EntityManagerInterface;
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

class EleveCrudController extends AbstractCrudController
{
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

            //FormField::addTab('Parents'),
            //CollectionField::new('parents')->allowAdd(true)->useEntryCrudForm()->setEntryIsComplex(),
        ];
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
            //$this->addFlash('notice', 'La fin ne peut pas etre inférieure au début');
            // let him take the natural course
            parent::persistEntity($entityManager, $entityInstance);
            $this->createInscription($entityManager, $entityInstance);

    }

    public function createInscription(EntityManagerInterface $entityManager,Eleve $eleve){

        $schoolYearRepository = $entityManager->getRepository(AnneeScolaire::class);
        $anneeEnCours = $schoolYearRepository->findActiveYear(true);

        $inscription = new Inscription();
        $inscription->setEleve($eleve);
        $inscription->setClasse($eleve->getClasseActuelle());

        parent::persistEntity($entityManager, $inscription);


    }
    
}
