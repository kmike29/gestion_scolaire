<?php

namespace App\Controller\Admin;

use App\Entity\ClasseAnneeScolaire;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use phpDocumentor\Reflection\Types\Boolean;

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
            BooleanField::new('active')->setFormTypeOption('disabled','disabled'),
        ];
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
            //$this->addFlash('notice', 'Paiement unique');
            // let him take the natural course
            $entityInstance->setFraisInscription($entityInstance->getClasse()->getFraisInscriptionDeBase());
            $entityInstance->setFraisScolarite($entityInstance->getClasse()->getFraisScolariteDeBase());

            parent::persistEntity($entityManager, $entityInstance);

    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('anneeScolaire')
        ;
    }
    
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            // the visible title at the top of the page and the content of the <title> element
            // it can include these placeholders:
            //   %entity_name%, %entity_as_string%,
            //   %entity_id%, %entity_short_id%
            //   %entity_label_singular%, %entity_label_plural%
            ->setPageTitle('index', 'Classes par années')
            ->setSearchFields([ 'active'])
            // you can pass a PHP closure as the value of the title
            //->setPageTitle('new', fn () => new \DateTime('now') > new \DateTime('today 13:00') ? 'New dinner' : 'New lunch')

            // in DETAIL and EDIT pages, the closure receives the current entity
            // as the first argument
            //->setPageTitle('detail', fn (Product $product) => (string) $product)
            //->setPageTitle('edit', fn (Category $category) => sprintf('Editing <b>%s</b>', $category->getName()))

            // the help message displayed to end users (it can contain HTML tags)
            //->setHelp('edit', '...')
        ;
}
    
}
