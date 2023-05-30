<?php

namespace App\Form;

use App\Entity\Avatar;
use App\Entity\LoginUser;
use App\Entity\User;
use App\Repository\AvatarRepository;
use Symfony\Component\Validator\Constraints\EqualTo;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use PHPUnit\Framework\Constraint\IsTrue;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\OptionsResolver\OptionsResolver;


class SignUpFormType extends AbstractType
{

    public EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $builder->add('avatar', EntityType::class, [
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

            ->add('username', TextType::class,[
                'mapped' => true,
                'label' => 'User Name',
                'attr' => [
                    'class' => 'field-form',
                    'placeholder' => 'Enter your user name'
                ]
            ])->add('password', RepeatedType::class,[
                'mapped' => false,
                'type' => PasswordType::class,
                'first_options'  => array(
                    'label' => 'Password',
                    'hash_property_path' => 'password',
                    'attr' => [
                    'class' => 'field-form',
                    'placeholder' => 'Enter your password'
                ]),
                'second_options' => array('label' => 'Repeat Password', 'attr' => [
                    'class' => 'field-form',
                    'placeholder' => 'Enter your password'
                ])

            ])->add('first_name', TextType::class,[
                'mapped' => true,
                'label' => 'First Name',
                'attr' => [
                    'class' => 'field-form',
                    'placeholder' => 'Enter your first name'
                ]
            ])
            ->add('last_name', TextType::class, [
                'mapped' => true,
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
                'mapped' => true,
                'label' => 'Date of birth',
                'attr' => [
                    'class' => 'date-form',
                ]
            ])
            ->add('street', TextType::class,[
                'mapped' => true,
                'label' => 'Street',
                'attr' => [
                    'class' => 'field-form',
                    'placeholder' => 'Enter your Address'
                ]
            ])
            ->add('house_number', NumberType::class,[
                'mapped' => true,
                'label'=>'House nr.',
                'attr'=>[
                    'class'=> 'field-form',
                    'placeholder'=>"House nr",
                ]
            ])
            ->add('postcode', NumberType::class,[
                'mapped' => true,
                'label'=>'Post code',
                'attr'=>[
                    'class'=> ' field-form',
                    'placeholder'=>"Post code",
                ]
            ])
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