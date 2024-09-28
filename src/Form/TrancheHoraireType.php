<?php

namespace App\Form;

use App\Entity\EmploiDuTemps;
use App\Entity\Personnel;
use App\Entity\TrancheHoraire;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TrancheHoraireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('jour', null, [
                'widget' => 'single_text',
            ])
            ->add('debut', null, [
                'widget' => 'single_text',
            ])
            ->add('fin', null, [
                'widget' => 'single_text',
            ])
            ->add('emploiDuTemps', EntityType::class, [
                'class' => EmploiDuTemps::class,
                'choice_label' => 'id',
            ])
            ->add('professeur', EntityType::class, [
                'class' => Personnel::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TrancheHoraire::class,
        ]);
    }
}
