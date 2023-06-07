<?php

namespace App\DataFixtures;

use App\Entity\UserBook;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserBookFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {
// open csv file and load data
        if (($handle = fopen(__DIR__."/data/user_book_data.csv", "r")) !== FALSE) {
            // read first line with headers
            $headers = fgetcsv($handle, 1000, ",");
            // read rest of file and create entities for every line
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $userbook = new UserBook();
                $userbook->setUserid($data[0]);
                $userbook ->setBookid($data[1]);
                $manager->persist($userbook);

            }
            $manager->flush();
        }    }
}