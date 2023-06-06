<?php

namespace App\Tests;

use App\Entity\Books;
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
        $title = 'The Blue Room'; // Title of the book you want to find
        // Retrieve the book from the entity manager using the title as the criteria
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
        $isbn = "216947934-1" ; // Title of the book you want to find
        // Retrieve the book from the entity manager using the title as the criteria
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
        $author = "Lynde Gallahue" ; // Title of the book you want to find
        // Retrieve the book from the entity manager using the title as the criteria
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


}