<?php

namespace App\Controller\Admin;

use App\Entity\ClasseAnneeScolaire;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ClasseAnneeScolaireCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ClasseAnneeScolaire::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('anneeScolaire'),
            AssociationField::new('Classe'),
        ];
    }
    
}
