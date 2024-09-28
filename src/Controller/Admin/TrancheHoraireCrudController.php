<?php

namespace App\Controller\Admin;

use App\Entity\TrancheHoraire;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TimeField;

class TrancheHoraireCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return TrancheHoraire::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            DateField::new('jour'),
            TimeField::new('debut'),
            TimeField::new('fin'),
            AssociationField::new('emploiDuTemps'),
            AssociationField::new('matiere'),
            AssociationField::new('professeur'),
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
