<?php

namespace App\DataFixtures;

use App\Entity\MeetUp;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class MeetupFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {
        // open csv file and load data
        if (($handle = fopen(__DIR__."/data/libraries.csv", "r")) !== FALSE) {
            // read first line with headers
            $headers = fgetcsv($handle, 1000, ",");
            // read rest of file and create entities for every line
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $meetup = new MeetUp();
                $meetup->setIdUserInviter($data[0]);
                $meetup ->setIdUserInvited($data[1]);
                $meetup -> setDateTime($data[2]);
                $meetup -> setAccepted($data[3]);
                $meetup -> setDeclined($data[4]);
                $meetup -> setIdLibrary($data[5]);
                $manager->persist($meetup);

            }
            $manager->flush();
        }
    }
}