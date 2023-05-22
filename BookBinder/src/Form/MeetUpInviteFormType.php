<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class MeetUpInviteFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name invited', TextareaType::class, [
                'label' => 'Name:',
                'attr' => [
                    'class' => 'mb-3 form-control align-self-center ',
                ],
            ])
            ->add('date', DateTimeType::class, [
                'label' => 'Date:',
                'format' => 'Y-MM-dd HH-mm-ss',
            ])
            ->add('library', TextareaType::class, [
                'label' => 'Library:',
                'attr' => [
                    'class' => 'mb-3 form-control align-self-center',
                ],
            ])
            ->add('Submit', SubmitType::class, [
                'attr' => [
                    'class' => 'BookBtns',
                ],
            ]);
    }
}