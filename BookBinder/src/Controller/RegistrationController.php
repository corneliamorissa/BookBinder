<?php

namespace App\Controller;

use App\Entity\LoginUser;
use App\Form\SignUpFormType;
use App\Service\AuthenticationService;
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
    public function signup(Request $request, UserPasswordHasherInterface $passwordHasher): Response {

        $form = $this->createForm(SignUpFormType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $username = $form->get('username')->getData();
            $password = $form->get('password')->getData();

            $user = new LoginUser($username,$password);
            $plaintextPassword = $user->getPassword() ;

            // hash the password (based on the security.yaml config for the $user class)
            $hashedPassword = $passwordHasher->hashPassword(
                $user,
                $plaintextPassword
            );
            $user->setPassword($hashedPassword);
        }
        // ... e.g. get the user data from a registration form



        /*if ($form->isSubmitted() && $form->isValid()) {
            $username = $form->get('username')->getData();
            $password = $form->get('password')->getData();
            // Perform login authentication
            if ($this->checkLogin($username, $password)) {
                // Authentication successful
                $session->set('username', $username);
                // Redirect to homepage or some other page
                return $this->redirectToRoute('LogIn');
            } else {
                // Authentication failed
                $this->addFlash('error', 'Invalid username or password');
            }
        }*/

        return $this->render('signup.html.twig', [
            'stylesheets' => $this->stylesheets,
            'form'=>$form->createView()
        ]);
    }
}
