<?php

namespace App\Form;

use App\Entity\Planning;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Evenement;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class PlanningType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('hour', null, [
                'attr' => [
                    'placeholder' => 'HH:MM'
                ]
            ])
            ->add('nomactivite')
            ->add('datepl', null, [
                'attr' => [
                    'placeholder' => 'YYYY-MM-DD'
                ]
            ])
            ->add('idev',EntityType::class,['class'=> Evenement::class,
        'choice_label'=>'nomev',
        'choice_value'=>'nomev',
        'label'=>'Nom Evenement'])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Planning::class,
        ]);
    }
}
