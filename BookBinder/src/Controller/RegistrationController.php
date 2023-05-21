<?php

namespace App\Controller;

use App\Entity\Avatar;
use App\Entity\LoginUser;
use App\Entity\User;
use App\Form\SignUpFormType;
use App\Repository\AvatarRepository;
use App\Repository\UserRepository;
use App\Service\AuthenticationService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{

    private array $stylesheets;

    public function __construct(AuthenticationService $userService) {
        $this->stylesheets[] = 'main.css';
    }
    /**
     * @Route("/SignUp", name="SignUp")
     */
    #[Route("/SignUp", name: "SignUp")]
    public function signup(Request $request, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager, AvatarRepository $ap): Response {


        $avatar = $ap->findAll();
        $form = null;
        //$form = $this->createForm(SignUpFormType::class);
        $user = new User();
        $form = $this->createFormBuilder( $user )
            ->add('avatar', EntityType::class, [
                'class' => Avatar::class,
                'choices' => $entityManager->getRepository(Avatar::class)->findAll(),
                'choice_label' => function ($avatar) use ($entityManager) {
                    $imageBlob = $avatar->getImage();
                    $base64Image = base64_encode(stream_get_contents($imageBlob));
                    $dataUri = 'data:image/png;base64,' . $base64Image;

                    // Store the data URI in a temporary property to access it in choice_attr
                    $avatar->setDataUri($dataUri);
                },
                'choice_attr' => function ($avatar) {
                    // Access the data URI stored in the temporary property
                    $dataUri = $avatar->getDataUri();

                    // Set the 'data-image-url' attribute with the image data URI
                    return ['data-image-url' => $dataUri];
                },
                'choice_value' => 'id',
                'mapped' => true,
                'multiple' => false,
                'expanded' => true,
                'attr' => [
                    'class' => 'avatar-choice',
                    'placeholder' => 'Choose one for your avatar'
                ]
            ])
            ->add('username', TextType::class,[
                'mapped' => true,
                'label' => 'User Name',
                'attr' => [
                    'class' => 'form-control field-form',
                    'placeholder' => 'Enter your user name'
                ]
            ])->add('password', RepeatedType::class,[
                'mapped' => true,
                'type' => PasswordType::class,
                'first_options'  => array('label' => 'Password', 'attr' => [
                    'class' => 'form-control field-form',
                    'placeholder' => 'Enter your password'
                ]),
                'second_options' => array('label' => 'Repeat Password', 'attr' => [
                    'class' => 'form-control field-form',
                    'placeholder' => 'Enter your password'
                ])

            ])->add('first_name', TextType::class,[
                'mapped' => true,
                'label' => 'First Name',
                'attr' => [
                    'class' => 'form-control field-form',
                    'placeholder' => 'Enter your first name'
                ]
            ])
            ->add('last_name', TextType::class, [
                'mapped' => true,
                'label' => 'Last Name',
                'attr' => [
                    'class' => 'form-control field-form',
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
                    'class' => 'form-control field-form',
                    'placeholder' => 'Enter your Address'
                ]
            ])
            ->add('house_number', TextType::class,[
                'mapped' => true,
                'label'=>'House nr.',
                'attr'=>[
                    'class'=> 'form-control field-form',
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
                'mapped' => true,
                'label'=>'Post code',
                'attr'=>[
                    'class'=> 'form-control field-form',
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
            ])->getForm()
        ;


        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $user = $form->getData();


            $plaintextPassword = $user->getPassword() ;

            // hash the password (based on the security.yaml config for the $user class)
            $hashedPassword = $passwordHasher->hashPassword(
                $user,
                $plaintextPassword
            );
            $user->setPassword($hashedPassword);

            // 4) save the User!
            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success', 'Account Succesfully Created! Log in is needed');
            return $this->redirectToRoute('LogIn');
        }

        return $this->render('signup.html.twig', [
            'stylesheets' => $this->stylesheets,
            'form'=>$form,
            'avatar' => $avatar
        ]);
    }
}
