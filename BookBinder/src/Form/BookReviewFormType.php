<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;



class BookReviewFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('author', TextType::class,[
                'label'=> 'Author:',
                'attr'=>[
                    'readonly'=> true,
                    'class'=> 'mb-3 form-control align-self-center ',
                ],
            ])
            ->add('book',TextType::class,[
                'label'=>'Book Name:',
                'attr'=>[
                    'readonly'=> true,
                    'class'=>'mb-3 form-control align-self-center',
                ],
            ])
            ->add('text',TextareaType::class,[
                'label'=>'Enter your feedback:',
                'attr'=>[
                    'class'=>'mb-3 form-control align-self-center',
                ],
            ])

            ->add('rate',ChoiceType::class,[
                'label'=> 'Select your rating:',
                'choices'=>[
                    '1'=>1,
                    '2' => 2,
                    '3' => 3,
                    '4' => 4,
                    '5' => 5,
                    '6' => 6,
                    '7' => 7,
                    '8' => 8,
                    '9' => 9,
                    '10' => 10,
                ],
                'attr'=>[
                    'class'=>'mb-3 form-select align-self-center',
                ],
            ])
            ->add('Submit',SubmitType::class,[
                'attr'=>[
                    'class'=>'BookBtns',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
