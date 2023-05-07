<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $roles = ['ROLE_USER' => 'User', 'ROLE_ADMIN' => 'Admin', 'ROLE_ORG' => 'Organization' ];

        $builder
            ->add('name', null, [
                'attr' => ['class' => 'form-control mb-3'],
            ])
            ->add('email', null, [
                'attr' => ['class' => 'form-control mb-3'],
            ])
            ->add('roles', ChoiceType::class, [
                'choices' => $roles,
                'placeholder' => 'Choose a role',
                'required' => true,
                'multiple' => true,
                'attr' => ['class' => 'form-control mb-3'],
            ])
            ->add('password', PasswordType::class, [
                'attr' => ['class' => 'form-control mb-3'],
            ])
            ->add('image',FileType::class, [
                'label'=>false,
                'mapped'=>false,
                'required'=>false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
