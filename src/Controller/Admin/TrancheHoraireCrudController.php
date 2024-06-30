<?php

namespace App\Controller\Admin;

use App\Entity\TrancheHoraire;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
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
    
}
