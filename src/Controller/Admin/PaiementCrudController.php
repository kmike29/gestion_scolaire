<?php

namespace App\Controller\Admin;

use App\Entity\Paiement;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class PaiementCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Paiement::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            ChoiceField::new('type')->setChoices([
                'tranche' => 'tranche',
            ]),
            MoneyField::new('montant')->setCurrency('XAF')->setNumDecimals(0)->setStoredAsCents(false),
        ];
    }
}
