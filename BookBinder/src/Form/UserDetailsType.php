<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserDetailsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('First_name', TextType::class,[
                'label'=>'First name',
                'attr'=>[
                    'class'=> 'Field',
                    'value'=>"Andrea",
                ],
                'disabled'=>true,
            ])
            ->add('Last_name', TextType::class,[
                'label'=>'Last name',
                'attr'=>[
                    'class'=> 'Field',
                    'value'=>"Anderson",
                ],
                'disabled'=>true,
            ])
            /*
            ->add('Date_of_birth', TextType::class,[
                'label'=>'Date of birth',
                'attr'=>[
                    'class'=> 'Field',
                    'value'=>"31/12/2021",
                ],
                'disabled'=>true,
            ])
           /* ->add('Address', TextType::class,[
                'label'=>'Address',
                'attr'=>[
                    'class'=> 'Field',
                    'value'=>"Attendreef 41",
                ],
                'disabled'=>true,
            ])/*
            ->add('house_number', TextType::class,[
                'label'=>'House nr.',
                'attr'=>[
                    'class'=> 'Field',
                    'value'=>"1130",
                ],
                'disabled'=>true,
            ])/*
            ->add('City', TextType::class,[
                'label'=>'City',
                'attr'=>[
                    'class'=> 'Field',
                    'value'=>"Holsbeek",
                ],
                'disabled'=>true,

            ])/*->add('Post_code', TextType::class,[
                'label'=>'Post code',
                'attr'=>[
                    'class'=> 'Field',
                    'value'=>"3230",
                ],
                'disabled'=>true,
            ])
            /*
            ->add('Library', TextType::class,[
                'label'=>'Library',
                'attr'=>[
                    'class'=> 'Field',
                    'value'=>"Library name",
                ],
                'disabled'=>true,
            ])
            */
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
