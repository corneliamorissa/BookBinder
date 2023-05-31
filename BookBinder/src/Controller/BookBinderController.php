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
use App\Form\MeetUpAcceptFormType;
use App\Form\MeetUpDeclineFormType;
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
use Symfony\Component\HttpFoundation\RedirectResponse;
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
        $UserObject = $em->getRepository(\App\Entity\User::class)->findOneBy(['username'=> $this->lastUsername]);
        $UserId = $UserObject->getID();
        $FollowedBookByUser = $em->getRepository(UserBook::class)->displayFollowedBooksPerUser($UserId);
        return $this->render('home.html.twig', [
            'stylesheets' => $this->stylesheets,
            'last_username' => $this->lastUsername,
            'books' => $books,
            'library' => $library,
            'followedBooks'=>$FollowedBookByUser,
            'javascripts' => ['api.js'],
        ]);
    }

    #[Route("/User", name: "User")]
    #[IsGranted('ROLE_USER')]
    public function user(Request $request, EntityManagerInterface $em): Response {
        $user = $em->getRepository(\App\Entity\User::class)->findUserByName($this->lastUsername);
        $avatarid = $user['avatar_id'];
        $avatar = $em ->getRepository(Avatar::class) -> findOneBy(['id' => $avatarid ]);
        if($avatar) {
            $imageBlob = $avatar->getImage();
            $base64Image = base64_encode(stream_get_contents($imageBlob));
            $dataUri = 'data:image/png;base64,' . $base64Image;
        }
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
            'avatar'=> $avatar,
            'data_image_url' => $dataUri

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
    public function search(Request $request, BooksRepository $booksRepository, EntityManagerInterface $em)
    {
        $books = $em->getRepository(Books::class)->findTopBooks();
        $UserObject = $em->getRepository(\App\Entity\User::class)->findOneBy(['username'=> $this->lastUsername]);
        $UserId = $UserObject->getID();
        $FollowedBookByUser = $em->getRepository(UserBook::class)->displayFollowedBooksPerUser($UserId);
        return $this->render('search.html.twig', [
            'stylesheets' => $this->stylesheets,
            'last_username' => $this->lastUsername,
            'books' => $books,
            'followedBooks'=>$FollowedBookByUser,
            'javascripts' => ['api.js'],
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
        $user_ID = $user->getID();
        //$allSentMeetups = $em->getRepository(MeetUp::class)->findBy(['id_user_inviter' => $userID]);
        //$allReceivedMeetups = $em->getRepository(MeetUp::class)->findBy(['id_user_invited' => $userID]);
        //$allMeetups = array_merge($allSentMeetups,$allReceivedMeetups);
        $all_open_meetups = $em->getRepository(MeetUp::class)->findBy(['id_user_invited' => $user_ID,'accepted' => 0,'declined' => 0]);
        $all_open_meetups_data = array();
        $forms_accept = array();
        $forms_decline = array();
        foreach ( $all_open_meetups as $meet_up){
            $meet_up_data = new MeetUpData(
                ($em->getRepository(\App\Entity\User::class)->findOneBy(['id'=> $meet_up->getIdUserInviter()]))->getUsername(),
                $meet_up->getDateTime(),
                ($em->getRepository(Library::class)->findOneBy(['id'=> $meet_up->getIdLibrary()]))->getName()
            );

            $form_accept = $this->createForm(MeetUpAcceptFormType::class,$meet_up);
            $form_accept ->handleRequest($request);
            if($form_accept->isSubmitted() && $form_accept->isValid()){
                $meet_up->setAccepted(1);
                $em->flush();
                return $this->redirectToRoute('MeetUp');
            }
            $form_decline = $this->createForm(MeetUpDeclineFormType::class,$meet_up);
            $form_decline ->handleRequest($request);
            if($form_decline->isSubmitted() && $form_decline->isValid()){
                $meet_up->setDeclined(1);
                $em->flush();
                return $this->redirectToRoute('MeetUp');
            }
            array_push($all_open_meetups_data,$meet_up_data);
            array_push($forms_accept,$form_accept->createView());
            array_push($forms_decline,$form_decline->createView());
        }
        /*To pass accepted meetups*/
        $current_date_time = new DateTime('now');
        $all_accepted_meetups = $em->getRepository(MeetUp::class)->findBy(['id_user_invited' => $user_ID,'accepted' => 1,'declined' => 0]);
        $all_accepted_meetups_data = array();
        foreach( $all_accepted_meetups as $meetup ) {
            if ($meetup->getDateTime() > $current_date_time) {
            $meet_up_data = new MeetUpData(
                ($em->getRepository(\App\Entity\User::class)->findOneBy(['id' => $meetup->getIdUserInviter()]))->getUsername(),
                $meetup->getDateTime(),
                ($em->getRepository(Library::class)->findOneBy(['id' => $meetup->getIdLibrary()]))->getName()
            );
            $avatarid = ($em->getRepository(\App\Entity\User::class)->findOneBy(['id' => $meetup->getIdUserInviter()]))->getAvatarId();
            $avatar = $em->getRepository(Avatar::class)->findOneBy(['id' => $avatarid]);
            if ($avatar) {
                $image_blob = $avatar->getImage();
                $base64_image = base64_encode(stream_get_contents($image_blob));
                $data_uri = 'data:image/png;base64,' . $base64_image;
            }
            $meet_up_data->setDataUri($data_uri);
            array_push($all_accepted_meetups_data, $meet_up_data);
            }
        }

        usort($all_accepted_meetups_data, function ($a, $b) {
            $datetime_a = $a->getDateTime();
            $datetime_b = $b->getDateTime();

            if ($datetime_a == $datetime_b) {
                return 0;
            }

            return ($datetime_a < $datetime_b) ? -1 : 1;
        });
        /* Form to invite someone*/
        $datetime = new DateTime();
        $meetup_form = new MeetUpData("",$datetime,"");
        $meetup = new MeetUp($user_ID,0,$datetime,0,0,0);
        $form = $this->createForm(MeetUpInviteFormType::class,$meetup_form);
        $form ->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            if (($invited_user = ($em->getRepository(User::class)->findOneBy(['username' => $meetup_form->getNameInvited()]))) != null){
                $user1 = $invited_user;
                $meetup->setIdUserInvited($user1->getId());
                if (($library = $em->getRepository(Library::class)->findOneBy(['name' => $meetup_form->getNameLibrary()])) != null){
                    $library1 = $library;
                    $meetup->setIdLibrary($library1->getID());
                    $meetup->setDateTime($meetup_form->getDateTime());
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

        /*Form to accept invite*/

        return $this->render('meetup.html.twig', [
            'stylesheets' => $this->stylesheets,
            'form'=>$form->createView(),
            'formAccept'=>$forms_accept,
            'formDecline'=>$forms_decline,
            'last_username' => $this->lastUsername,
            //'all_meetups' => $allMeetups,
            'date_time' => $datetime,
            //'all_received_meetups' => $allReceivedMeetups,
            //'all_sent_meetups' => $allSentMeetups,
            'all_open_meetups' => $all_open_meetups_data,
            'all_accepted_meetups' => $all_accepted_meetups_data,
            'MeetUp' => $meetup_form
        ]);
    }

    #[Route("/Book/{BookId}", name: "Book")]
    #[IsGranted('ROLE_USER')]
    public function book(Request $Request, EntityManagerInterface $EntityManager, int $BookId ): Response {
        /*Book details*/
        $BookObject = $EntityManager->getRepository(Books::class)->find($BookId);
        $BookTitle  =$BookObject->getTitle();
        $BookNrOfFollowers = $BookObject->getNumberOffollowers();
        $BookNrOfPages = $BookObject->getNumberOfpages();
        $BookIsbn = $BookObject->getISBN();
        $BookRating = $BookObject->getRating();
        $BookLibraryId = $BookObject->getLibrary();
        /*Get follow information*/
        $UserObject = $EntityManager->getRepository(\App\Entity\User::class)->findOneBy(['username'=> $this->lastUsername]);
        $UserId = $UserObject->getID();
        $FollowObject =$EntityManager->getRepository(UserBook::class)->getBooksByUserID($UserId);
        $UserFollowsBookBoolean = 0;  /*User doesnt follow the book-> display the follow btn*/
        if (!empty($FollowObject)){
            foreach ($FollowObject as $UserBookCombination){
                if ($UserBookCombination->getBookid() == $BookId){
                    $UserFollowsBookBoolean=1;
                    break;
                }
            }
        }
        /*Getting reviews for a book based on the book name*/
        $ReviewsPerBookObject = $EntityManager->getRepository(Review::class)->getReviewBasedOnBookName($BookTitle);
        $LibraryNameObject = $EntityManager->getRepository(Books::class)->getLibraryNameById($BookLibraryId);
        /*Feedback form*/
        $ReviewForm = $this->createForm(BookReviewFormType::class, new Review());
        $ReviewForm ->handleRequest($Request);
        if($ReviewForm->isSubmitted() && $ReviewForm->isValid()){
            $EntityManager->persist($ReviewForm->getData());
            $EntityManager->flush();
            $this->addFlash('success', 'Your review was submitted successfully!');
            return $this->redirectToRoute('Book', ['BookId' => $BookId]);
        }

        $FollowBookForm = $this->createForm(FollowFormType::class,new UserBook());
        $FollowBookForm->handleRequest($Request);
        if($FollowBookForm->isSubmitted()&&$FollowBookForm->isValid()){
            $EntityManager->persist( $FollowBookForm->getData());
            $EntityManager->flush();
            $this->addFlash('success', 'Book Followed Successfully');
            return $this->redirectToRoute('Book', ['BookId' => $BookId]);
        }

        $UnfollowBookForm = $this->createForm(UnfollowFormType::class, null,[
            'action'=>$this->generateUrl('unfollow_book',['userID'=>$UserId, 'bookID'=>$BookId])
        ]);

        return $this->render('book.html.twig', [
            'stylesheets' => $this->stylesheets,
            'ReviewForm'=>$ReviewForm->createView(),
            'FollowBookForm'=>$FollowBookForm->createView(),
            'UnfollowBookForm' => $UnfollowBookForm->createView(),
            'last_username' => $this->lastUsername,
            'BookTitle' => $BookTitle,
            'BookNrOfFollowers'=>$BookNrOfFollowers,
            'BookNrOfPages'=>$BookNrOfPages,
            'BookIsbn'=>$BookIsbn,
            'BookRating'=>$BookRating,
            'LibraryName'=>$LibraryNameObject,
            'ReviewsPerBook' => $ReviewsPerBookObject,
            'UserFollowsBookBoolean'=>$UserFollowsBookBoolean,
            'BookId'=>$BookId,
            'UserId'=>$UserId,
        ]);
    }

    /**
     * @Route("/unfollow_book/{userID}/{bookID}", name="unfollow_book")
     */
    public function unfollowBook(int $userID, int $bookID, Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(UnfollowFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userBook = $em->getRepository(UserBook::class)->findUserBook($userID, $bookID);

            if ($userBook !== null) {
                $em->remove($userBook);
                $em->flush();
            }
            $this->addFlash('success', 'Book Unfollowed successfully!');
            return $this->redirectToRoute('Book', ['BookId' => $bookID]);
        }
        return new RedirectResponse($request->headers->get('referer'));
    }

}
