<?php

namespace App\DataFixtures;

use App\Entity\Books;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class BooksFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {
        // open csv file and load data
        if (($handle = fopen(__DIR__."/data/books.csv", "r")) !== FALSE) {
            // read first line with headers
            $headers = fgetcsv($handle, 1000, ",");
            // read rest of file and create entities for every line
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $book = new Books();
                $book->setTitle($data[0]);
                $book ->setNumberOfpages($data[1]);
                $book -> setAuthor($data[2]);
                $book -> setISBN($data[3]);
                $book -> setNumberOffollowers($data[4]);
                $book -> setLibrary($data[5]);
                $book -> setRating($data[6]);
                $book -> setNumberOfvotes($data[7]);
                $manager->persist($book);

            }
            $manager->flush();
        }
    }
}