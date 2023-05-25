<?php

namespace App\Form;

use App\Entity\Avatar;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserDetailsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('avatar', EntityType::class, [
            'class' => Avatar::class,
            'mapped' => true,
            'expanded' => true,
            'required' => true,
            'label' => '',
            'block_name' => 'custom_avatar',
            'attr' => [
                'class' => 'avatar-choice',
                'id' => 'avatar-choices',
                'placeholder' => 'Choose one for your avatar'
            ],
            'choice_attr' => function ($avatar) {
                $dataUri = ''; // Initialize the data URI

                if ($avatar) {
                    $avatarId = $avatar->getId(); // Access the ID of the Avatar entity
                    $imageBlob = $avatar->getImage();
                    $base64Image = base64_encode(stream_get_contents($imageBlob));
                    $dataUri = 'data:image/png;base64,' . $base64Image;
                }

                return ['data-image-url' => $dataUri]; // Use the ID as the key
            },
        ])

            /*
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
