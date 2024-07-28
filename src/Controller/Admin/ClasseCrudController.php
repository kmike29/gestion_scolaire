<?php

namespace App\Controller\Admin;

use App\Entity\Classe;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;

class ClasseCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Classe::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Classe')
            ->setEntityLabelInPlural('Classes')
            ->setDateFormat('MM/yyyy')
            ->setPageTitle('index', 'Gestion des %entity_label_plural% ')
            ->setTimezone('UTC')
            ->setPaginatorPageSize(30)
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            
            FormField::addTab('Informations'),
            TextField::new('nom'),
            MoneyField::new('fraisScolariteDeBase')->setCurrency('XAF')->setStoredAsCents(false),
            MoneyField::new('fraisInscriptionDeBase')->setCurrency('XAF')->setStoredAsCents(false),
            AssociationField::new('niveau'),
            AssociationField::new('classeSuperieure'),

            FormField::addTab('Matieres')->hideWhenCreating(),
            CollectionField::new('matieres')->allowAdd(true)->useEntryCrudForm()->setEntryIsComplex()->hideWhenCreating(),

        ];
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        foreach( $entityInstance->getMatieres() as $matiere){
            $matiere->generateId();
        }
        try{
            parent::persistEntity($entityManager, $entityInstance);
        }catch(\Exception $e){
            $this->addFlash('error', 'Une matière a été attribué plusieurs fois à la classe. Veuillez corriger');
        }

    }

    public function checkDuplicateCourses(Classe $classe){


    }



    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
