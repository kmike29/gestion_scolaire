<?php

namespace App\Controller\Admin;

use App\Entity\AnneeScolaire;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
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
