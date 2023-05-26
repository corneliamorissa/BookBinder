<?php

namespace App\Form;

use App\Entity\MeetUpData;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MeetUpAcceptFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void{
        $builder
            ->add('Submit', SubmitType::class, [
                'label' => 'Accept',
                'attr' => [
                    'class' => 'accept',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            //
        ]);
    }
}