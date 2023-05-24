<?php

namespace App\Controller;

use App\Entity\Avatar;
use App\Entity\Books;
use App\Entity\MeetUp;
use App\Entity\Library;
use App\Entity\MeetUpData;
use App\Entity\User;
use App\Entity\Review;
use App\Entity\UserBook;
use App\Form\BookReviewFormType;
use App\Form\FollowFormType;
use App\Form\LoginFormType;
use App\Form\MeetUpInviteFormType;
use App\Form\SearchBookFormType;
use App\Form\SignUpFormType;
use App\Form\UnfollowFormType;
use App\Form\UserDetailsType;
use App\Repository\BooksRepository;
use App\Repository\UserRepository;
use App\Service\AuthenticationService;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
//use http\Client\Curl\User;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\LoginUser;
use App\Entity\Db;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use function PHPUnit\Framework\isInstanceOf;

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
    public function home(EntityManagerInterface $em): Response {
        $library = $em->getRepository(Library::class)->findNearestLibrary($this->lastUsername);
        $books = $em->getRepository(Books::class)->findTopBooks();
        return $this->render('home.html.twig', [
            'stylesheets' => $this->stylesheets,
            'last_username' => $this->lastUsername,
            'books' => $books,
            'library' => $library,
            'javascripts' => ['api.js']
        ]);
    }

    #[Route("/User", name: "User")]
    #[IsGranted('ROLE_USER')]
    public function user(Request $request, EntityManagerInterface $em): Response {
        $user = $em->getRepository(\App\Entity\User::class)->findUserByName($this->lastUsername);
        $avatar = $em ->getRepository(Avatar::class)->findAvatarByName($this->lastUsername);
        $id = $avatar -> getId();
        $library = $em->getRepository(Library::class)->findNearestLibrary($this->lastUsername);
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
            'last_username' => $this->lastUsername,
            'user' => $user,
            'library' => $library,
            'avatar'=> $avatar
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
    public function search(Request $request, BooksRepository $booksRepository)
    {
        return $this->render('search.html.twig', [
            'stylesheets' => $this->stylesheets,
            'last_username' => $this->lastUsername,
        ]);
    }

    #[Route("/search/book/{isbn}", name: "search_book")]
    #[IsGranted('ROLE_USER')]
    public function findBookByISBN(string $isbn, BooksRepository $booksRepository): JsonResponse
    {
        $book = $booksRepository->findBookByISBN($isbn);

        if ($book) {
            $response = $book;
        } else {
            $response = ['title' => null];
        }

        return new JsonResponse($response);
    }

    #[Route("/MeetUp", name: "MeetUp")]
    #[IsGranted('ROLE_USER')]
    public function meetup(Request $request, EntityManagerInterface $em): Response {
        $user = $em->getRepository(\App\Entity\User::class)->findOneBy(['username'=> $this->lastUsername]);
        $userID = $user->getID();
        $allSentMeetups = $em->getRepository(MeetUp::class)->findBy(['id_user_inviter' => $userID]);
        $allReceivedMeetups = $em->getRepository(MeetUp::class)->findBy(['id_user_invited' => $userID]);
        $allMeetups = array_merge($allSentMeetups,$allReceivedMeetups);
        $allOpenMeetups = $em->getRepository(MeetUp::class)->findBy(['id_user_inviter' => $userID,'accepted' => 0,'declined' => 0]);
        $allAcceptedMeetups = $em->getRepository(MeetUp::class)->findBy(['id_user_inviter' => $userID,'accepted' => 1,'declined' => 0]);

        /* Form to invite someone*/
        $datetime = new DateTime();
        $meetUpForm = new MeetUpData("",$datetime,"");
        $meetup = new MeetUp($userID,0,$datetime,0,0,0);
        $form = $this->createForm(MeetUpInviteFormType::class,$meetUpForm);
        $form ->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            if (($invitedUser = ($em->getRepository(User::class)->findOneBy(['username' => $meetUpForm->getNameUserInvited()]))) != null){
                $user1 = $invitedUser;
                $meetup->setIdUserInvited($user1->getId());
                if (($library = $em->getRepository(Library::class)->findOneBy(['name' => $meetUpForm->getNameLibrary()])) != null){
                    $library1 = $library;
                    $meetup->setIdLibrary($library1->getID());
                    $meetup->setDateTime($meetUpForm->getDateTime());
                    $em->persist($meetup);
                    $em->flush();
                }
                else{
                    $this->addFlash('faillibrary', 'Please enter a valid library name.');
                }
            }
            else{
                $this->addFlash('failname', 'Please enter a valid  username.');
            }
            /*Message to be displayed in the case of successful review submission and the reload the page to prevent multiple submissions by reloading the page!*/
            $this->addFlash('success', 'Your Meetup request was submitted successfully!');
            return $this->redirectToRoute('MeetUp');
        }
        return $this->render('meetup.html.twig', [
            'stylesheets' => $this->stylesheets,
            'form'=>$form->createView(),
            'last_username' => $this->lastUsername,
            'all_meetups' => $allMeetups,
            'date_time' => $datetime,
            'all_received_meetups' => $allReceivedMeetups,
            'all_sent_meetups' => $allSentMeetups,
            'all_open_meetups' => $allOpenMeetups,
            'all_accepted_meetups' => $allAcceptedMeetups,
        ]);
    }

    #[Route("/Book/{id}", name: "Book")]
    #[IsGranted('ROLE_USER')]
    public function book(Request $request, EntityManagerInterface $em, int $id ): Response {
        /*Book details*/
        $book = $em->getRepository(Books::class)->find($id);
        $title  =$book->getTitle();
        $bookid = $book->getId();
        /*Get follow information*/
        $user = $em->getRepository(\App\Entity\User::class)->findOneBy(['username'=> $this->lastUsername]);
        $userID = $user->getID();
        $follow =$em->getRepository(UserBook::class)->getBooksByUserID($userID);
        /*I can refactor this probably but ill do sa later. :)*/
        if (empty($follow)){
            $ff = 0; /*User doesnt follow the book-> display the follow btn*/
        }else{
            $followids = array_column($follow, 'bookid');
            if(in_array($bookid,$followids)){
                $ff = 1;
            }else{
                $ff=0;
            }
        }
        /*Getting reviews for a book based on the book name*/
        $display = $em->getRepository(Review::class)->getReviewBasedOnBookName($title);
        /*End of getting reviews*/
        $nrFollowers = $book->getNumberOffollowers();
        $author = $book->getAuthor();
        $pages = $book->getNumberOfpages();
        $isbn = $book->getISBN();
        $rating = $book->getRating();
        $libraryId = $book->getLibrary();
        $library = $em->getRepository(Books::class)->getLibraryNameById($libraryId);
        /*Feedback form*/
        $reviewform = new Review();
        $form = $this->createForm(BookReviewFormType::class, $reviewform);
        $form ->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $reviewform = $form->getData();
            $em->persist($reviewform);
            $em->flush();
            /*Message to be displayed in the case of successful review submission and the reload the page to prevent multiple submissions by reloading the page!*/
            $this->addFlash('success', 'Your review was submitted successfully!');
            return $this->redirectToRoute('Book', ['id' => $id]);
        }
        $followform = new UserBook();
        $form1 = $this->createForm(FollowFormType::class,$followform);
        $form1->handleRequest($request);
        if($form1->isSubmitted()&&$form1->isValid()){
            $followform = $form1->getData();
            $em->persist($followform);
            $em->flush();
            $this->addFlash('success', 'Book Followed Successfully');
            return $this->redirectToRoute('Book', ['id' => $id]);
        }


        return $this->render('book.html.twig', [
            'stylesheets' => $this->stylesheets,
            'form'=>$form->createView(),
            'form1'=>$form1->createView(),
            'last_username' => $this->lastUsername,
            'title' => $title,
            'nrFollowers'=>$nrFollowers,
            'author'=>$author,
            'pages'=>$pages,
            'isbn'=>$isbn,
            'rating'=>$rating,
            'library'=>$library,
            'display' => $display,
            'ff'=>$ff,
            'bookid'=>$bookid,
            'userid'=>$userID,
            'follow' => $follow,

        ]);
    }

    /*#[Route("/Book/{id}/Unfollow", name: "Book_Unfollow")]
    #[IsGranted('ROLE_USER')]
    public function unfollowBook(Request $request, EntityManagerInterface $em, int $id):Response
    {
        $user = $em->getRepository(\App\Entity\User::class)->findOneBy(['username'=> $this->lastUsername]);
        $book = $em->getRepository(Books::class)->find($id);

        $form = $this->createForm(UnfollowFormType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $userBook = $em->getRepository(UserBook::class)
                ->findOneBy(['user' => $user, 'book' => $book]);
            if ($userBook) {
                $em->remove($userBook);
                $em->flush();
                $this->addFlash('success', 'Book Unfollowed Successfully');
            } else {
                $this->addFlash('error', 'You are not following this book');
            }
        }
        return $this->redirectToRoute('Book', [

            'id' => $book->getId()]);

    }*/


}
