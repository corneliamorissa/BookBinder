<?php

namespace App\Controller;

use App\Entity\Books;
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
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class BookBinderController extends AbstractController
{
    private array $stylesheets;
    private string $lastUsername;

    public function __construct(AuthenticationService $userService, AuthenticationUtils $authenticationUtils) {
        $this->stylesheets[] = 'main.css';
        /*the last username to store username that is logged in in every pages, so usernale could be siplayed at top right*/
        $this->lastUsername = $authenticationUtils->getLastUsername();

    }


    #[Route("/Home", name: "Home")]
    #[IsGranted('ROLE_USER')]
    public function home(): Response {

        return $this->render('home.html.twig', [
            'stylesheets' => $this->stylesheets,
            'last_username' => $this->lastUsername
        ]);
    }


    #[Route("/privacypolicy", name: "privacypolicy")]
    #[IsGranted('ROLE_USER')]
    public function privacypolicy(): Response {
        return $this->render('privacypolicy.html.twig',[
            'last_username' => $this->lastUsername
        ]);
    }


    #[Route("/termsofservice", name: "termsofservice")]
    #[IsGranted('ROLE_USER')]
    public function termsofservice(): Response {
        return $this->render('termsofservice.html.twig',[
            'last_username' => $this->lastUsername
        ]);
    }

    #[Route("/Search", name: "Search")]
    #[IsGranted('ROLE_USER')]
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
            'last_username' => $this->lastUsername
        ]);
    }

    #[Route("/MeetUp", name: "MeetUp")]
    #[IsGranted('ROLE_USER')]
    public function meetup(): Response {
        return $this->render('meetup.html.twig', [
            'stylesheets' => $this->stylesheets,
            'last_username' => $this->lastUsername
        ]);
    }

    #[Route("/User", name: "User")]
    #[IsGranted('ROLE_USER')]
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
            'last_username' => $this->lastUsername
        ]);
    }

    #[Route("/Book/{id}", name: "Book")]
   #[IsGranted('ROLE_USER')]
    public function book(Request $request, EntityManagerInterface $em, int $id ): Response {
        /*Book details*/
        $book = $em->getRepository(Books::class)->find($id);
        $title  =$book->getTitle();
        $nrFollowers = $book->getNumberOffollowers();
        $author = $book->getAuthor();
        $pages = $book->getNumberOfpages();
        $isbn = $book->getISBN();
        $rating = $book->getRating();
        $libraryId = $book->getLibrary();
        $library = $em->getRepository(Books::class)->getLibraryNameById($libraryId);
        /*Feedback form*/
        $form = $this->createForm(BookReviewFormType::class);
        $form ->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $feedBackForm = $form->getData();
            $em->persist($feedBackForm);
            $em->flush();
            return $this->redirectToRoute('Home'); /*To change this*/
        }

        return $this->render('book.html.twig', [
            'stylesheets' => $this->stylesheets,
            'form'=>$form->createView(),
            'last_username' => $this->lastUsername,
            'title' => $title,
            'nrFollowers'=>$nrFollowers,
            'author'=>$author,
            'pages'=>$pages,
            'isbn'=>$isbn,
            'rating'=>$rating,
            'library'=>$library
        ]);
    }


}
