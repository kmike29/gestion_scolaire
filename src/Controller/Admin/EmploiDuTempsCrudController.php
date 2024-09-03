<?php

namespace App\Controller\Admin;

use App\Entity\EmploiDuTemps;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class EmploiDuTempsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return EmploiDuTemps::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('classe'),
        ];
    }

}
