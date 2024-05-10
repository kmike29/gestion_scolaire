<?php

namespace App\Controller\Admin;

use App\Entity\Eleve;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class EleveCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Eleve::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            FormField::addTab("Informations de l'élève "),
            ImageField::new('photo')->setBasePath('public/students/photos/')->setUploadDir('public/students/photos/')->setFormTypeOptions(['attr' => [
                'accept' => 'image/*',
            ],
            ]),
            TextField::new('nom'),
            TextField::new('prenoms'),
            TextField::new('lieuDeNaissance')->setLabel('Lieu de naissance'),
            TextField::new('nationalite')->setLabel('Nationalité'),
            DateField::new('dateDeNaissance')->setLabel('Date de naissance'),
            DateField::new('dateDInscription')->setLabel("Date d'inscription"),
            TextField::new('ecoleDeProvenance')->setLabel('Ecole de provenance'),
            //FormField::addTab('Parents'),
            //CollectionField::new('parents')->allowAdd(true)->useEntryCrudForm()->setEntryIsComplex(),
        ];
    }
    
}
