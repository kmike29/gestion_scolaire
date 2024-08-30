<?php

namespace App\Form;

use App\Entity\ClasseAnneeScolaire;
use App\Entity\Inscription;
use App\Entity\Paiement;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfonycasts\DynamicForms\DependentField;
use Symfonycasts\DynamicForms\DynamicFormBuilder;

class DynamicPaiementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        /**
         * Install DynamicFormBuilder:.
         *
         *    composer require symfonycasts/dynamic-forms
         */
        $builder = new DynamicFormBuilder($builder);

        $builder
            ->add('classe', EntityType::class, [
                'class' => ClasseAnneeScolaire::class,
                'choice_label' => fn (ClasseAnneeScolaire $cas): string => $cas->__toString(),
                'placeholder' => 'Choisir une classe',
                'autocomplete' => true,
                'mapped'=>false,
                'attr' => ['class' =>"form-control"]
            ])
            ->add('type', ChoiceType::class, [
                'choices' => [
                    "Frais d'inscriptions" => 'inscription',
                    'Frais de scolarité' => 'scolarité',
                ],
                'placeholder' => 'Choisir un type de paiement',

            ])


            ->addDependent('inscription',['classe','type'], function (DependentField $field, ?ClasseAnneeScolaire $classe,?string $type)
                {
                    $field->add(EntityType::class, [
                        'class' => Inscription::class,
                        'placeholder' => null === $classe ? 'Choisir une classe' : 'Quel élève',
                        'choices' => null === $classe ? [] : $classe->getInscriptionsIncompletes(),
                        'choice_label' => fn (Inscription $inscription): string => $inscription->__toString(),
                        'disabled' => null === $classe || $type === null,
                        'autocomplete' => true,
                        'attr' => ['class' =>"form-control"]
                    ]);
                }
            )

            ->addDependent('status', ['inscription' , 'type'], function (DependentField $field, ?Inscription $inscription,?string $type){
                // ajout du status uniquemment sur les paiement de scolarité
                if($type == 'scolarité'){
                    $field->add(TextType::class, [
                        'attr' => [
                            'value' =>  null === $inscription ? 'Choisissez un élève' : $inscription->getStatusPaiement(),
                            'style' => 'width: 300px',
                            'class'=> "form-control"
                        ],
                        'mapped'=> false,
                        'disabled' => true,
                    ]);
                }
            })


            ->addDependent('montant', ['inscription' , 'type'], function (DependentField $field, ?Inscription $inscription,?string $type){
                // ajout du status uniquemment sur les paiement de scolarité
                if($type == 'scolarité' && $inscription){
                        $field->add(MoneyType::class, [
                            'label' => 'Montant versé',
                            'currency' => 'XAF',
                            'attr' => ['class' =>"form-control"],
                        ]);
                }
                if($type == 'inscription' && $inscription){
                    $field->add(MoneyType::class, [
                        'label' => 'Montant versé',
                        'currency' => 'XAF',
                        'attr' => ['class' =>"form-control",'value' => $inscription->getFraisInscription()],
                        'disabled' => true,
                    ]);
                }
            }
            )

            // see: https://github.com/SymfonyCasts/dynamic-forms
            /*->addDependent('status', 'inscription', function (DependentField $field, ?Inscription $meal) {
                $field->add(EnumType::class, [
                    'class' => Food::class,
                    'placeholder' => null === $meal ? 'Select a meal first' : \sprintf('What\'s for %s?', $meal->getReadable()),
                    'choices' => $meal?->getFoodChoices(),
                    'choice_label' => fn (Food $food): string => $food->getReadable(),
                    'disabled' => null === $meal,
                    'autocomplete' => true,
                ]);
            })*/

            /*->addDependent('pizzaSize', 'mainFood', function (DependentField $field, ?Food $food) {
                if (Food::Pizza !== $food) {
                    return;
                }

                $field->add(EnumType::class, [
                    'class' => PizzaSize::class,
                    'placeholder' => 'What size pizza?',
                    'choice_label' => fn (PizzaSize $pizzaSize): string => $pizzaSize->getReadable(),
                    'required' => true,
                    'autocomplete' => true,
                ]);
            })*/
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => Paiement::class]);
    }
}
