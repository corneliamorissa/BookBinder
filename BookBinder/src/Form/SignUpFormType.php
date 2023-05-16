<?php

namespace App\Form;

use App\Entity\LoginUser;
use App\Entity\User;
use PHPUnit\Framework\Constraint\IsTrue;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\OptionsResolver\OptionsResolver;


class SignUpFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('username', TextType::class,[
            'label' => 'User Name',
            'attr' => [
                'class' => 'field-form',
                'placeholder' => 'Enter your user name'
            ]
        ])->add('password', RepeatedType::class,[
            'type' => PasswordType::class,
            'first_options'  => array('label' => 'Password', 'attr' => [
                'class' => 'field-form',
                'placeholder' => 'Enter your password'
            ]),
            'second_options' => array('label' => 'Repeat Password', 'attr' => [
                'class' => 'field-form',
                'placeholder' => 'Enter your password'
            ])

        ])->add('first_name', TextType::class,[
            'label' => 'First Name',
            'attr' => [
                'class' => 'field-form',
                'placeholder' => 'Enter your first name'
            ]
        ])
            ->add('last_name', TextType::class, [
                'label' => 'Last Name',
                'attr' => [
                    'class' => 'field-form',
                    'placeholder' => 'Enter your last name'
                ]
            ])
            ->add('birthdate', BirthdayType::class,[
                'placeholder' => [
                    'year' => 'Year', 'month' => 'Month', 'day' => 'Day',
                ],
                'label' => 'Date of birth',
                'attr' => [
                    'class' => 'date-form',
                ]
            ])
            ->add('street', TextType::class,[
                'label' => 'Street',
                'attr' => [
                    'class' => 'field-form',
                    'placeholder' => 'Enter your Address'
                ]
            ])
            ->add('house_number', TextType::class,[
                'label'=>'House nr.',
                'attr'=>[
                    'class'=> 'field-form',
                    'placeholder'=>"House nr",
                ]
            ])
//            ->add('City', TextType::class,[
//                'label'=>'City',
//                'attr'=>[
//                    'class'=> 'field-form',
//                    'placeholder'=>'City',
//                ]
//            ])
            ->add('postcode', TextType::class,[
                'label'=>'Post code',
                'attr'=>[
                    'class'=> 'field-form',
                    'placeholder'=>"Post code",
                ]
            ])
//            ->add('Library', TextType::class,[
//                'label'=>'Library',
//                'attr'=>[
//                    'class'=> 'field-form',
//                    'placeholder'=>"Library name",
//                ]
//            ])
            ->add('terms_and_condition', CheckboxType::class,[
                'mapped' => false,
                'label' => 'By signing up, you agree to our Terms & Conditions ',
                'required' => true,
                'attr' =>[
                    'class' => 'terms-form',
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Sign Up',
                'attr' => [
                    'class' => 'signup-button',
                ]
            ])
        ;

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
            'data_class' => User::class,
        ]);
    }
}