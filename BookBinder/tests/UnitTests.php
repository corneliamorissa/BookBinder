<?php declare(strict_types=1);

namespace App\Tests;

use App\Entity\Library;
use App\Entity\MeetUp;
use App\Entity\MeetUpData;
use App\Entity\User;
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

        $this->assertSame(1,$avatar -> getId());
        $this->assertSame("blob data", $avatar -> getImage());



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


    }
    public function testMeetupGetAttributes(): void
    {
        $datetime = new DateTime();
        $meetup = new Meetup();
        $meetup -> setId(1);
        $meetup -> setIdUserInviter(1);
        $meetup -> setIdUserInvited(22);
        $meetup -> setDateTime($datetime);
        $meetup -> setAccepted(0);
        $meetup -> setDeclined(0);
        $meetup -> setIdLibrary(0);

        $this->assertSame(1,$meetup->getId());
        $this->assertSame(1,$meetup->getIdUserInviter());
        $this->assertSame(22,$meetup->getIdUserInvited());
        $this->assertSame($datetime,$meetup->getDateTime());
        $this->assertSame(0,$meetup->getAccepted());
        $this->assertSame(0,$meetup->getDeclined());
        $this->assertSame(0,$meetup->getIdLibrary());


    }

    public function testMeetupDataGetAttributes(): void{

        $datetime = new DateTime();
        $meetUpForm = new MeetUpData();
        $meetUpForm -> setNameUserInvited("Joop");
        $meetUpForm -> setDateTime($datetime);
        $meetUpForm -> setNameLibrary("La Library");

        $this -> assertSame("Joop",$meetUpForm->getNameUserInvited());
        $this -> assertSame($datetime,$meetUpForm->getDateTime());
        $this -> assertSame("La Library",$meetUpForm->getNameLibrary());

    }


}