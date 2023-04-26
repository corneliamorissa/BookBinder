<?php

namespace App\Controller;

use App\Form\BookReviewFormType;
use App\Form\SearchBookFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use function Sodium\add;

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
    public function login(Request $request): Response {
        $session = $request->getSession();
        $form = null;
        $form = $this->createFormBuilder(null)
            ->add('username', TextType::class, ['mapped' => false])
            ->add('password', PasswordType::class ,['mapped' => false])
            ->add('submit',SubmitType::class, ['label'=> 'Log In'])
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $username = $data['username'];
            $password = $data['password'];
            // Perform login authentication
            if ($this->checkLogin($username, $password)) {
                // Authentication successful
                $session->set('user', $username);
                // Redirect to homepage or some other page
                return $this->redirectToRoute('Home');
            } else {
                // Authentication failed
                $this->addFlash('error', 'Invalid username or password');
            }
        }



        return $this->render('login.html.twig', [
            'stylesheets' => $this->stylesheets,
            'login_form' => $form
        ]);
    }

    function checkLogin($username, $password): bool
    {
        // Check if username and password are valid
        // Perform any necessary database queries or API calls
        // Return true if authentication succeeds, false otherwise


        return true;
    }

    /**
     * @Route("/SignUp", name="SignUp")
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
     * @Route("/Search", name="Search")
     */
    #[Route("/Search", name: "Search")]
    public function search(Request $request, EntityManagerInterface $em): Response {
        $form = $this->createForm(SearchBookFormType::class);
        $form ->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $feedBackForm = $form->getData();
            $em->persist($feedBackForm);
            $em->flush();
            return $this->redirectToRoute('Home');
        }
        return $this->render('search.html.twig', [
            'stylesheets' => $this->stylesheets,
            'form'=>$form->createView(),
        ]);
    }

    /**
     * @Route("/MeetUp", name="MeetUp")
     */
    #[Route("/MeetUp", name: "MeetUp")]
    public function meetup(): Response {
        return $this->render('meetup.html.twig', [
            'stylesheets' => $this->stylesheets
        ]);
    }

    /**
     * @Route("/User", name="User")
     */
    #[Route("/User", name: "User")]
    public function user(): Response {
        return $this->render('user.html.twig', [
            'stylesheets' => $this->stylesheets
        ]);
    }

    /**
     * @Route("/Book", name="Book")
     */
    #[Route("/Book", name: "Book")]
    public function book(Request $request, EntityManagerInterface $em ): Response {
        $form = $this->createForm(BookReviewFormType::class);
        $form ->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $feedBackForm = $form->getData();
            $em->persist($feedBackForm);
            $em->flush();
            return $this->redirectToRoute('Home');
        }

        return $this->render('book.html.twig', [
            'stylesheets' => $this->stylesheets,
            'form'=>$form->createView(),
        ]);
    }
}
