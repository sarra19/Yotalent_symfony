<?php

namespace App\Form;

use App\Entity\Ticket;
use App\Entity\Evenement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class TicketType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('prixt')
        
        // ->add('etat')
        ->add('idev',EntityType::class,['class'=> Evenement::class,
        'choice_label'=>'nomev',
        'choice_value'=>'nomev',
        'label'=>'Nom Evenement'])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Ticket::class,
          
        ]);
    }
}
