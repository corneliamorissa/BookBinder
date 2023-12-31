<?php

namespace App\Controller;
use App\Entity\Books;
use App\Entity\Library;
use App\Form\LoginFormType;
use App\Service\AuthenticationService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\SecurityBundle\SecurityBundle;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController
{

    private array $stylesheets;

    public function __construct(AuthenticationService $user_service) {
        $this->stylesheets[] = 'main.css';

    }

    /**
     * @Route("/", name="LogIn", methods={"GET", "POST"})
     */
    #[Route("/", name: "LogIn")]
    public function index(AuthenticationUtils $authentication_utils,EntityManagerInterface $em): Response {
        $books = $em->getRepository(Books::class)->findTopBooks();
        $first_book = $books[0];
        $second_book = $books[1];
        $third_book = $books[2];
        $error = $authentication_utils->getLastAuthenticationError();
        // last username entered by the user
        $last_username = $authentication_utils->getLastUsername();

        return $this->render('login.html.twig', [
            'stylesheets' => $this->stylesheets,
            'last_username' => $last_username,
            'error'         => $error,
            'first_book' => $first_book,
            'second_book' => $second_book,
            'third_book' => $third_book,
            'javascripts' => ['api.js'],
        ]);
    }


}