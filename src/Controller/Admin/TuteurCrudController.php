<?php

namespace App\Controller\Admin;

use App\Entity\Tuteur;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class TuteurCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Tuteur::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('nom'),
            TextField::new('prenoms'),
            TextField::new('telephone'),
            ChoiceField::new('relation')->setChoices([
                'Père' => 'Père',
                'Mère' => 'Mère',
                'Oncle' => 'Oncle',
            ]),
            TextField::new('metier'),

        ];
    }

}
