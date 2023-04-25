<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookBinderController extends AbstractController
{
    private array $stylesheets;

    public function __construct() {
        $this->stylesheets[] = 'main.css';
    }

    /**
     * @Route("/LogIn", name="LogIn")
     */
    #[Route("/LogIn", name: "LogIn")]
    public function login(): Response {
        return $this->render('login.html.twig', [
            'stylesheets' => $this->stylesheets
        ]);
    }

    /**
     * @Route("/LogIn", name="LogIn")
     */
    #[Route("/SignUp", name: "SignUp")]
    public function signup(): Response {
        return $this->render('signup.html.twig', [
            'stylesheets' => $this->stylesheets
        ]);
    }

    /**
     * @Route("/Home", name="Home")
     */
    #[Route("/Home", name: "Home")]
    public function home(): Response {
        return $this->render('home.html.twig', [
            'stylesheets' => $this->stylesheets
        ]);
    }

    /**
     * @Route("/Home", name="Home")
     */
    #[Route("/Search", name: "Search")]
    public function search(): Response {
        return $this->render('home.html.twig', [
            'stylesheets' => $this->stylesheets
        ]);
    }

    /**
     * @Route("/Home", name="Home")
     */
    #[Route("/MeetUp", name: "MeetUp")]
    public function meetup(): Response {
        return $this->render('meetup.html.twig', [
            'stylesheets' => $this->stylesheets
        ]);
    }

    /**
     * @Route("/Home", name="Home")
     */
    #[Route("/User", name: "User")]
    public function user(): Response {
        return $this->render('home.html.twig', [
            'stylesheets' => $this->stylesheets
        ]);
    }

    /**
     * @Route("/Home", name="Home")
     */
    #[Route("/Book", name: "Book")]
    public function book(): Response {
        return $this->render('book.html.twig', [
            'stylesheets' => $this->stylesheets
        ]);
    }
}
