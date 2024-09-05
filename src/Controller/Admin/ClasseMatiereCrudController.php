<?php

namespace App\Controller\Admin;

use App\Entity\ClasseMatiere;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ClasseMatiereCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ClasseMatiere::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('classe')->hideWhenCreating(),
            AssociationField::new('matiere'),
            NumberField::new('coefficient'),

        ];
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
