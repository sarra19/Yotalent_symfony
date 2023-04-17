<?php

namespace App\Form;

use App\Entity\Espacetalent;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\NotNull;


class EspacetalentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username')
            ->add('image', FileType::class, [
                'label' => 'Image',
                'mapped' => false, // do not map this field to the entity property
                'required' => true,
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'image/gif',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid image file',
                    ])
                ],
            ])
            ->add('nbvotes')
           
         
           
           
            ->add('idcat', null, [
                'data' => $options['current_idcat'],
                'disabled' => false,
                'constraints' => [
                    new NotNull([
                        'message' => 'Please select an option',
                    ]),
                ],
            ])
            ->add('idu', null, [
                'data' => $options['current_idu'],
                'disabled' => false,
                'constraints' => [
                    new NotNull([
                        'message' => 'Please select an option',
                    ]),
                ],
            ])
        ;

        
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Espacetalent::class,
          'current_idcat' => null,
            'current_idu' => null,
        ]);
    }

    
}
