<?php declare(strict_types=1);

namespace App\Tests;

use App\Entity\Library;
use App\Entity\MeetUp;
use App\Entity\MeetUpData;
use App\Entity\Review;
use App\Entity\User;
use App\Entity\UserBook;
use PHPUnit\Framework\TestCase;
use App\Entity\Avatar;
use App\Entity\Books;
use DateTime;


class UnitTests extends TestCase
{

    public function testAvatarGetAttributes(): void{

        $avatar = new Avatar();



        //$this->assertSame(null, $avatar -> getImage());

        $avatar -> setId(1);
        $avatar -> setImage("blob data");
        $avatar -> setDataUri("www.test");

        $this->assertSame(1,$avatar -> getId());
        $this->assertSame("blob data", $avatar -> getImage());
        $this -> assertSame("www.test",$avatar->getDataUri());
        $this -> assertSame("1",$avatar -> __toString());



    }
    public function testBookGetAttributes(): void{
        $book = new Books();

        $book -> setId(1);
        $book -> setTitle("Harry Potter and the Order of the Phoenix (Harry Potter  #5)");
        $book -> setNumberOfpages(870);
        $book -> setAuthor("J.K. Rowling/Mary GrandPré");
        $book -> setISBN("9780439358071");
        $book -> setNumberOffollowers(215367);
        $book -> setLibrary(56);
        $book -> setRating(8.5);
        $book -> setNumberOfvotes(2);

        //Difference between assertSame and assertEquals is that with assertequals it
        // compares if two variables or expressions have equal values, regardless of their types and with assertSame
        // it checks if two variables refer to the exact same object or value, including their types.

        $this -> assertSame(1,$book -> getId());
        $this -> assertSame("Harry Potter and the Order of the Phoenix (Harry Potter  #5)",$book->getTitle());
        $this -> assertSame(870,$book -> getNumberOfpages());
        $this -> assertSame("J.K. Rowling/Mary GrandPré",$book->getAuthor());
        $this -> assertSame("9780439358071",$book->getISBN());
        $this -> assertSame(215367,$book -> getNumberOffollowers());
        $this -> assertSame(56,$book -> getLibrary());
        $this -> assertSame(8.5,$book -> getRating());
        $this -> assertSame(2,$book -> getNumberOfvotes());








    }
    public function testLibraryGetAttributes(): void{
        $library = new Library();

        $library -> setId(1);
        $library -> setName("The City of Los Santos Public Library");
        $library -> setStreet("Los Santos Avenue");
        $library -> setHousenumber(27);
        $library -> setPostcode(9042);

        $this -> assertSame(1,$library->getId());
        $this -> assertSame("The City of Los Santos Public Library",$library->getName());
        $this -> assertSame("Los Santos Avenue",$library->getStreet());
        $this -> assertSame(27,$library->getHousenumber());
        $this -> assertSame(9042,$library->getPostcode());



    }


    public function testMeetupGetAttributes(): void
    {
        $datetime = new DateTime();
        $meetup = new MeetUp(1,2,$datetime,0,0,0);
        $meetup -> setId(1);

        $this->assertSame(1,$meetup->getId());
        $this->assertSame(1,$meetup->getIdUserInviter());
        $this->assertSame(2,$meetup->getIdUserInvited());
        $this->assertSame($datetime,$meetup->getDateTime());
        $this->assertSame(0,$meetup->getAccepted());
        $this->assertSame(0,$meetup->getDeclined());
        $this->assertSame(0,$meetup->getIdLibrary());

        $datetime2 = new DateTime();

        $meetup -> setIdUserInviter(12);
        $meetup -> setIdUserInvited(22);
        $meetup -> setDateTime($datetime2);
        $meetup -> setAccepted(1);
        $meetup -> setDeclined(1);
        $meetup -> setIdLibrary(45);

        $this->assertSame(12,$meetup->getIdUserInviter());
        $this->assertSame(22,$meetup->getIdUserInvited());
        $this->assertSame($datetime2,$meetup->getDateTime());
        $this->assertSame(1,$meetup->getAccepted());
        $this->assertSame(1,$meetup->getDeclined());
        $this->assertSame(45,$meetup->getIdLibrary());


    }


    public function testMeetupDataGetAttributes(): void{
        $datetime = new DateTime();
        $meetUpForm = new MeetUpData("Joop",$datetime,"La Library");

        $this -> assertSame("Joop",$meetUpForm->getNameInvited());
        $this -> assertSame($datetime,$meetUpForm->getDateTime());
        $this -> assertSame("La Library",$meetUpForm->getNameLibrary());

        $datetime2 = new DateTime();
        $meetUpForm -> setNameUserInvited("Jelle");
        $meetUpForm -> setDateTime($datetime2);
        $meetUpForm -> setNameLibrary("NYC Library");
        $meetUpForm -> setDataUri("test");

        $this -> assertSame("Jelle",$meetUpForm->getNameInvited());
        $this -> assertSame($datetime2,$meetUpForm->getDateTime());
        $this -> assertSame("NYC Library",$meetUpForm->getNameLibrary());
        $this -> assertSame("test",$meetUpForm->getDataUri());

    }
    public function testReviewGetAttributes(): void{
        $review = new Review();

        //$this -> assertSame(null,$review->getText());

        $review -> setId(1);
        $review -> setText("Great");
        $review -> setAuthor("Billy__Boma5879");
        $review -> setBook("The Hobbit");
        $review -> setRate(8);

        $this -> assertSame(1,$review->getId());
        $this -> assertSame("Great",$review->getText());
        $this -> assertSame("Billy__Boma5879",$review->getAuthor());
        $this -> assertSame("The Hobbit",$review -> getBook());
        $this -> assertSame(8,$review->getRate());



    }

    public function testUserGetAttributes(): void{
        $user = new User();

        $this -> assertSame(0,$user -> getPrivateAccount());

        $user -> setId(1);
        $user -> setFirstName("Bert");
        $user -> setLastName("Smith");
        $user -> setUsername("Bert__Smith1578");
        $user -> setStreet("Oude Markt");
        $user -> setHouseNumber(2);
        $user -> setPostcode(3001);
        $birthday = new DateTime();
        $birthday->setDate(1990, 10, 15);
        $user -> setBirthdate($birthday);
        $user -> setPrivateAccount(1);
        $user -> setAvatarId(2);
        $user -> setPassword("azertyqwerty");
        $user -> setTermsAndCondition(true);


        $this->assertSame(1,$user->getId());
        $this->assertSame("Bert", $user -> getFirstName());
        $this->assertSame("Smith", $user -> getLastName());
        $this->assertSame("Bert__Smith1578", $user -> getUsername());
        $this->assertSame("Oude Markt",$user -> getStreet());
        $this->assertSame(2,$user -> getHouseNumber());
        $this->assertSame(3001,$user -> getPostcode());
        $this->assertSame($birthday,$user -> getBirthdate());
        $this->assertSame(1,$user -> getPrivateAccount());
        $this->assertSame(2,$user -> getAvatarId());
        $this->assertSame("azertyqwerty",$user -> getPassword());
        $this->assertSame(true,$user -> isTermsAndCondition());
        $this -> assertSame("Bert__Smith1578",$user->getUserIdentifier());

    }

    public function testUserBookGetAttributes(): void
    {
        $userbook = new UserBook();

        $userbook -> setId(1);
        $userbook -> setBookid(225);
        $userbook -> setUserid(88);

        $this -> assertSame(1,$userbook->getId());
        $this -> assertSame(225,$userbook -> getBookid());
        $this -> assertSame(88,$userbook-> getUserid());


    }






    }