<?php

namespace App\DataFixtures;

use App\Entity\MeetUp;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class MeetupFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {
        // open csv file and load data
        if (($handle = fopen(__DIR__."/data/meetup_data.csv", "r")) !== FALSE) {
            // read first line with headers
            $headers = fgetcsv($handle, 1000, ",");
            // read rest of file and create entities for every line
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $inviter = $data[0];
                $invited = $data[1];
                $date_time = new DateTime($data[2]);
                $accepted = $data[3];
                $denied = $data[4];
                $library = $data[5];
                $meetup = new MeetUp($inviter, $invited, $date_time, $accepted, $denied, $library);
                //$meetup = new MeetUp($data[0],$data[1],$data[2],$data[3],$data[4],$data[5]);
                /*
                $meetup->setIdUserInviter($data[0]);
                $meetup ->setIdUserInvited($data[1]);
                $meetup -> setDateTime($data[2]);
                $meetup -> setAccepted($data[3]);
                $meetup -> setDeclined($data[4]);
                $meetup -> setIdLibrary($data[5]);
                */
                $manager->persist($meetup);

            }
            $manager->flush();
        }
    }
}