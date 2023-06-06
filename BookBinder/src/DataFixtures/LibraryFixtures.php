<?php

namespace App\DataFixtures;

use App\Entity\Library;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class LibraryFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {
        // open csv file and load data
        if (($handle = fopen(__DIR__."/data/libraries.csv", "r")) !== FALSE) {
            // read first line with headers
            $headers = fgetcsv($handle, 1000, ",");
            // read rest of file and create entities for every line
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $library = new Library();
                $library->setName($data[0]);
                $library ->setStreet($data[1]);
                $library -> setHousenumber($data[2]);
                $library -> setPostcode($data[3]);
                $manager->persist($library);

            }
            $manager->flush();
        }
    }
}