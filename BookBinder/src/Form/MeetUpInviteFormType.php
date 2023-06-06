<?php

namespace App\Form;

use App\Entity\MeetUpData;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MeetUpInviteFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name_invited', TextareaType::class, [
                'label' => 'Name:',
                'attr' => [
                    'class' => 'mb-3 form-control align-self-center ',
                ],
            ])
            ->add('dateTime', DateTimeType::class, [
                'label' => 'Date:',
                'html5' => false,
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
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => MeetUpData::class,
        ]);
    }
}