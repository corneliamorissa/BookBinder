<?php

namespace App\Form;

use App\Entity\Books;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class SearchBookFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Search', SearchType::class,[
                'label'=>false,
                'attr'=>[
                    'class'=>'form-control me-auto',
                    'placeholder'=>'Search',
                    'aria-label'=> 'Search',
                ],
            ])
            ->add('SearchBtn',SubmitType::class,[
                'label'=>'Search',
                'attr'=>[
                    'class'=>'btn btn-outline-success','BookBtns',
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
