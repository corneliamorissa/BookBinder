<?php

namespace App\Controller;

use App\Entity\LoginUser;
use App\Entity\User;
use App\Form\SignUpFormType;
use App\Service\AuthenticationService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
    public function signup(Request $request, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager): Response {

        $user = new LoginUser();
        $detail_user = new User();

        $form = $this->createForm(SignUpFormType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $detail_user = $form->getData();
            $plaintextPassword = $user->getPassword() ;

            // hash the password (based on the security.yaml config for the $user class)
            $hashedPassword = $passwordHasher->hashPassword(
                $user,
                $plaintextPassword
            );
            $user->setPassword($hashedPassword);

            // 4) save the User!
            $entityManager->persist($user);
            $entityManager->persist($detail_user);
            $entityManager->flush();

            return $this->redirectToRoute('/');
        }

        return $this->render('signup.html.twig', [
            'stylesheets' => $this->stylesheets,
            'form'=>$form->createView()
        ]);
    }
}
