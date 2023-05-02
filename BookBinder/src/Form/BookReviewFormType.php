<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
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
            ->add('Rating', TextType::class,[
                'label'=> 'Rating',
                'attr'=>['class'=>'Rating',
                ],
            ])
            ->add('Feedback',TextareaType::class,[
                'label'=>'Enter your feedback:',
                'attr'=>[
                    'class'=>'Rating',
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
