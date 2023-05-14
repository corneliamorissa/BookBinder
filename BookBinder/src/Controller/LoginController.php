<?php

namespace App\Controller;
use App\Form\LoginFormType;
use App\Service\AuthenticationService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController
{

    private array $stylesheets;

    public function __construct(AuthenticationService $userService) {
        $this->stylesheets[] = 'main.css';

    }

    /**
     * @Route("/", name="LogIn", methods={"GET", "POST"})
     */
    #[Route("/", name: "LogIn")]
    public function index(AuthenticationUtils $authenticationUtils): Response {

        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('login.html.twig', [
            'stylesheets' => $this->stylesheets,
            'last_username' => $lastUsername,
            'error'         => $error
        ]);
    }

}