<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
       
    $roles = ['ROLE_USER' => 'User', 'ROLE_ADMIN' => 'Admin'];

        $builder
            ->add ('name')
            ->add('email')
            ->add('roles', ChoiceType::class, [
                'choices' => $roles,
                'placeholder' => 'Choose a role',
                'required' => true,
                'multiple' => true,

            ])
            ->add('password', PasswordType::class)
            ->add ('image')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
