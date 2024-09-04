<?php

namespace App\Form;

use App\Entity\ClasseAnneeScolaire;
use App\Entity\Eleve;
use App\Entity\Tuteur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EleveType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('prenoms')
            ->add('nationalite')
            ->add('ecoleDeProvenance')
            ->add('matricule')
            ->add('lieuDeNaissance')
            ->add('photo')
            ->add('sexe')
            ->add('dateDeNaissance', null, [
                'widget' => 'single_text',
            ])
            ->add('observations')
            ->add('personneAContacter1')
            ->add('personneAContacter2')
            ->add('numeroContact1')
            ->add('numeroContact2')
            ->add('dateDInscription', null, [
                'widget' => 'single_text',
            ])
            ->add('inscriptionComplete')
            ->add('parents', EntityType::class, [
                'class' => Tuteur::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
            ->add('classeActuelle', EntityType::class, [
                'class' => ClasseAnneeScolaire::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Eleve::class,
        ]);
    }
}
