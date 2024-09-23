<?php

namespace App\Controller\Admin;

use App\Entity\AnneeScolaire;
use App\Entity\Classe;
use App\Entity\ClasseAnneeScolaire;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class AnneeScolaireCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return AnneeScolaire::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('designation'),
            DateField::new('debut'),
            DateField::new('fin'),
            BooleanField::new('active')
        ];
    }


    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        //$this->addFlash('notice', 'La fin ne peut pas etre inférieure au début');
        // let him take the natural course

        parent::persistEntity($entityManager, $entityInstance);
        $this->createClasses($entityManager, $entityInstance);

    }

    public function createClasses(EntityManagerInterface $entityManager, AnneeScolaire $annéeScolaire): void
    {
        $classesRepository = $entityManager->getRepository(Classe::class);
        $classes = $classesRepository->findAll();

        foreach ($classes as $classe) {

            $gradeYear = new ClasseAnneeScolaire();
            $gradeYear->setAnneeScolaire($annéeScolaire) ;
            $gradeYear->setClasse($classe) ;
            $gradeYear->setFraisInscription($classe->getFraisInscriptionDeBase()) ;
            $gradeYear->setFraisScolarite($classe->getFraisScolariteDeBase()) ;
            parent::persistEntity($entityManager, $gradeYear);
        }

    }

    public function configureActions(Actions $actions): Actions
    {

        return $actions
            ->update(Crud::PAGE_NEW, Action::SAVE_AND_RETURN, function (Action $action) {
                return $action->setLabel('Sauvegarder');
            })
            ->update(Crud::PAGE_NEW, Action::SAVE_AND_ADD_ANOTHER, function (Action $action) {
                return $action->setLabel('Sauvegarder et ajouter un autre');
            });

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
