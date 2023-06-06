<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class RegistrationFixtures extends Fixture
{
    /**
     * @throws \Exception
     */
    public function load(ObjectManager $manager): void
    {

        // open csv file and load data
        if (($handle = fopen(__DIR__."/data/users.csv", "r")) !== FALSE) {
            // read first line with headers
            $headers = fgetcsv($handle, 1000, ",");
            // read rest of file and create entities for every line
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $user = new User();
                $user->setUsername($data[0]);
                $user->setFirstName($data[1]);
                $user->setLastName($data[2]);
                $user->setStreet($data[3]);
                $user->setHouseNumber($data[4]);
                $user->setPostcode($data[5]);
                $user->setBirthdate($data[6]);
                //$user->setPrivateAccount($data[7]);
                $user->setAvatarId($data[8]);
                $user->setPassword($data[9]);
                // store reference to object based on name (username)
                $this->addReference($user->getUsername(), $user);
                $manager->persist($user);
                $manager->flush();
            }
        }


    }
}
