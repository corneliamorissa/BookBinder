<?php

namespace App\Controller;

use App\Form\BookReviewFormType;
use App\Form\LoginFormType;
use App\Form\SearchBookFormType;
use App\Form\SignUpFormType;
use App\Form\UserDetailsType;
use App\Repository\UserRepository;
use App\Service\AuthenticationService;
use Doctrine\ORM\EntityManagerInterface;
use http\Client\Curl\User;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\LoginUser;
use App\Entity\Db;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class BookBinderController extends AbstractController
{
    private array $stylesheets;

    public function __construct(AuthenticationService $userService) {
        $this->stylesheets[] = 'main.css';

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
    public function user(Request $request, EntityManagerInterface $em): Response {
        $form = $this->createForm(UserDetailsType::class);
        $form ->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $feedBackForm = $form->getData();
            $em->persist($feedBackForm);
            $em->flush();
            return $this->redirectToRoute('Home');
        }
        return $this->render('user.html.twig', [
            'stylesheets' => $this->stylesheets,
            'form'=>$form->createView(),
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
