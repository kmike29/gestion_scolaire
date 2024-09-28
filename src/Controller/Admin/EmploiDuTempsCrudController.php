<?php

namespace App\Controller\Admin;

use App\Entity\EmploiDuTemps;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

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
