<?php

namespace App\Controller\Admin;

use App\Entity\Personnel;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class PersonnelCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Personnel::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            FormField::addTab("Informations personnels"),
            TextField::new('nom')->setLabel('Nom'),
            TextField::new('prenoms')->setLabel('Prénoms'),
            TextField::new('matricule')->setLabel('Numéro matricume'),
            DateField::new('dateDeNaissance')->setLabel('Date de naissance'),
            DateField::new('dateAjout')->setLabel('Date d ajout'),

            FormField::addTab("documents"),
            TextField::new('cv')->setLabel('CV'),
            TextField::new('numeroCNSS')->setLabel('Numéro CNSS'),
            TextField::new('compteBancaire')->setLabel('Compte bancaire'),
            TextField::new('diplomesAcademiques')->setLabel('Diplomes académiques'),
            TextField::new('diplomesProfessionnels')->setLabel('Diplomes professionnels'),
        ];
    }
    public function configureActions(Actions $actions): Actions
    {

        return $actions
            ->update(Crud::PAGE_NEW, Action::SAVE_AND_RETURN, function (Action $action) {
                return $action->setLabel('Enregistrer');
            })
            ->update(Crud::PAGE_NEW, Action::SAVE_AND_ADD_ANOTHER, function (Action $action) {
                return $action->setLabel('Enregistrer et ajouter un autre');
            });

    }
}
