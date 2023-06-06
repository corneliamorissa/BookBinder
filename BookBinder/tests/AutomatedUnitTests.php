<?php

namespace App\Tests;

use App\Entity\Books;
use App\Entity\Library;
use App\Entity\MeetUp;
use App\Entity\User;
use App\Entity\UserBook;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class AutomatedUnitTests extends KernelTestCase
{
    private $entity_manager;
    protected function setUp(): void
    {
        self::bootKernel();
        $this->entity_manager = self::$kernel->getContainer()->get('doctrine')->getManager();
    }

    public function testFindBooksCases():void{

        //First test finding by id
        $book_id = 1000;
        $book1 = $this->entity_manager->getRepository(Books::class)->find($book_id);

        $this -> assertSame($book_id,$book1 -> getId());
        $this -> assertSame("The Blue Room",$book1->getTitle());
        $this -> assertSame(182,$book1 -> getNumberOfpages());
        $this -> assertSame("Mona Dollard",$book1->getAuthor());
        $this -> assertSame("494811350-6",$book1->getISBN());
        $this -> assertSame(1,$book1 -> getNumberOffollowers());
        $this -> assertSame(915,$book1 -> getLibrary());
        $this -> assertSame(8.5,$book1 -> getRating());
        $this -> assertSame(212,$book1 -> getNumberOfvotes());

        //Second test finding by Title
        $title = 'The Blue Room';
        $book2 = $this->entity_manager->getRepository(Books::class)->findOneBy(['title' => $title]);

        $this -> assertSame($book_id,$book2 -> getId());
        $this -> assertSame("The Blue Room",$book2->getTitle());
        $this -> assertSame(182,$book2 -> getNumberOfpages());
        $this -> assertSame("Mona Dollard",$book2->getAuthor());
        $this -> assertSame("494811350-6",$book2->getISBN());
        $this -> assertSame(1,$book2 -> getNumberOffollowers());
        $this -> assertSame(915,$book2 -> getLibrary());
        $this -> assertSame(8.5,$book2 -> getRating());
        $this -> assertSame(212,$book2 -> getNumberOfvotes());


        //Third test find by ISBN
        $isbn = "216947934-1" ;
        $book3 = $this->entity_manager->getRepository(Books::class)->findOneBy(['isbn' => $isbn]);

        $this -> assertSame(876,$book3 -> getId());
        $this -> assertSame("Head of State",$book3->getTitle());
        $this -> assertSame(933,$book3 -> getNumberOfpages());
        $this -> assertSame("Mona Dollard",$book3->getAuthor());
        $this -> assertSame($isbn,$book3->getISBN());
        $this -> assertSame(553,$book3 -> getNumberOffollowers());
        $this -> assertSame(742,$book3 -> getLibrary());
        $this -> assertSame(3.0,$book3 -> getRating());
        $this -> assertSame(34,$book3 -> getNumberOfvotes());


        //Fourth test find by author
        $author = "Lynde Gallahue" ;
        $book4 = $this->entity_manager->getRepository(Books::class)->findOneBy(['author' => $author]);

        $this -> assertSame(601,$book4 -> getId());
        $this -> assertSame("All American Chump",$book4->getTitle());
        $this -> assertSame(3812,$book4 -> getNumberOfpages());
        $this -> assertSame($author,$book4->getAuthor());
        $this -> assertSame("122543781-4",$book4->getISBN());
        $this -> assertSame(6302,$book4 -> getNumberOffollowers());
        $this -> assertSame(187,$book4 -> getLibrary());
        $this -> assertSame(4.9,$book4 -> getRating());
        $this -> assertSame(437,$book4 -> getNumberOfvotes());


    }

    public function testFindLibraryCases():void{
        //First find by id
        $lib_id = 202;
        $library1 = $this->entity_manager->getRepository(Library::class)->find($lib_id);

        $this -> assertSame($lib_id,$library1->getId());
        $this -> assertSame("Temp",$library1->getName());
        $this -> assertSame("Buell",$library1 -> getStreet());
        $this -> assertSame(3,$library1->getHousenumber());
        $this -> assertSame(3505,$library1->getPostcode());

        //Second find by name
        $name = "Fixflex";
        $library2 = $this->entity_manager->getRepository(Library::class)->findOneBy(['name' => $name]);

        $this -> assertSame(244,$library2->getId());
        $this -> assertSame($name,$library2->getName());
        $this -> assertSame("School",$library2 -> getStreet());
        $this -> assertSame(8509,$library2->getHousenumber());
        $this -> assertSame(45,$library2->getPostcode());

        //Third find by postcode
        $postcode = 9579;
        $library3 = $this->entity_manager->getRepository(Library::class)->findOneBy(['postcode' => $postcode]);

        $this -> assertSame(782,$library3->getId());
        $this -> assertSame("Y-Solowarm",$library3->getName());
        $this -> assertSame("Mandrake",$library3 -> getStreet());
        $this -> assertSame(753,$library3->getHousenumber());
        $this -> assertSame($postcode,$library3->getPostcode());

    }

    public function testFindMeetupCases():void{
        //First find by id
        $meetup_id = 645;
        $meetup1 = $this->entity_manager->getRepository(MeetUp::class)->find($meetup_id);
        $first_time= new \DateTime('2023-09-19 16:14:36');

        $this -> assertSame($meetup_id,$meetup1->getId());
        $this -> assertSame(521,$meetup1->getIdUserInviter());
        $this -> assertSame(161,$meetup1 -> getIdUserInvited());
        $this->assertSame($first_time,$meetup1->getDateTime());
        $this->assertSame(0,$meetup1->getAccepted());
        $this->assertSame(0,$meetup1->getDeclined());
        $this->assertSame(25,$meetup1->getIdLibrary());

        //Second find by id_inviter
        $id_inviter = 388;
        $meetup2 = $this->entity_manager->getRepository(MeetUp::class)->findOneBy(['id_user_inviter' => $id_inviter]);
        $second_time= new \DateTime('2023-08-18 02:16:53');

        $this -> assertSame(712,$meetup2->getId());
        $this->assertSame($id_inviter,$meetup2->getIdUserInviter());
        $this->assertSame(685,$meetup2->getIdUserInvited());
        $this->assertSame($second_time,$meetup2->getDateTime());
        $this->assertSame(0,$meetup2->getAccepted());
        $this->assertSame(1,$meetup2->getDeclined());
        $this->assertSame(133,$meetup2->getIdLibrary());

        //Third find by id_invited
        $id_invited = 871;
        $meetup3 = $this->entity_manager->getRepository(MeetUp::class)->findOneBy(['id_user_inviter' => $id_invited]);
        $third_time= new \DateTime('2023-09-27 20:44:23');

        $this->assertSame(553,$meetup3->getId());
        $this->assertSame(537,$meetup3->getIdUserInviter());
        $this->assertSame($id_invited,$meetup3->getIdUserInvited());
        $this->assertSame($third_time,$meetup3->getDateTime());
        $this->assertSame(1,$meetup3->getAccepted());
        $this->assertSame(0,$meetup3->getDeclined());
        $this->assertSame(106,$meetup3->getIdLibrary());

    }

    public function testUserBookCases():void{
        //First by id
        $user_book_id = 115;
        $user_book1 = $this->entity_manager->getRepository(UserBook::class)->find($user_book_id);

        $this -> assertSame($user_book_id,$user_book1->getId());
        $this -> assertSame(224,$user_book1 -> getBookid());
        $this -> assertSame(331,$user_book1-> getUserid());

        //Second by userId
        $user_id = 225;
        $user_book2 = $this->entity_manager->getRepository(MeetUp::class)->findOneBy(['userid' => $user_id]);
        $this -> assertSame(230,$user_book2->getId());
        $this -> assertSame($user_id,$user_book2 -> getBookid());
        $this -> assertSame(198,$user_book2-> getUserid());

        //Third by bookId
        $book_id = 699;
        $user_book3 = $this->entity_manager->getRepository(MeetUp::class)->findOneBy(['bookid' => $book_id]);
        $this -> assertSame(282,$user_book3->getId());
        $this -> assertSame(342,$user_book3 -> getBookid());
        $this -> assertSame($book_id,$user_book3-> getUserid());

}

    public function testUserCases():void{
        //First by id
        $user_id = 461;
        $user1 = $this->entity_manager->getRepository(User::class)->find($user_id);
        $birthday1 = new \DateTime('2006-03-05');

        $this->assertSame($user_id,$user1->getId());
        $this->assertSame("Hillie", $user1 -> getFirstName());
        $this->assertSame("Yonnie", $user1 -> getLastName());
        $this->assertSame("hyonniecs", $user1 -> getUsername());
        $this->assertSame("Mayfield",$user1 -> getStreet());
        $this->assertSame(69,$user1 -> getHouseNumber());
        $this->assertSame("2589",$user1 -> getPostcode());
        $this->assertSame($birthday1,$user1 -> getBirthdate());
        $this->assertSame(10,$user1 -> getAvatarId());
        //$this->assertSame("gWzTwt1YSunG",$user1 -> getPassword()); ? test it like this?

        //Second by username


        $username ="griedel5q" ;
        $user2 = $this->entity_manager->getRepository(MeetUp::class)->findOneBy(['username' => $username]);
        $birthday2 = new \DateTime('2008-07-08');

        $this->assertSame(207,$user2->getId());
        $this->assertSame("Gery", $user2 -> getFirstName());
        $this->assertSame("Riedel", $user2 -> getLastName());
        $this->assertSame($username, $user2 -> getUsername());
        $this->assertSame("Donald",$user2 -> getStreet());
        $this->assertSame(62,$user2 -> getHouseNumber());
        $this->assertSame("83",$user2 -> getPostcode());
        $this->assertSame($birthday2,$user2 -> getBirthdate());
        $this->assertSame(18,$user2 -> getAvatarId());
        //$this->assertSame("ZEYIQt",$user2 -> getPassword());
    }


}