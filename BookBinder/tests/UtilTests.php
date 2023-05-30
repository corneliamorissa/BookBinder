<?php

namespace App\Tests;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UtilTests extends WebTestCase
{
    public function testRouteLogin(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('#login_top_trending', 'Top Trending Books');
        $trendingBook = $crawler->filter('.booktitle');
        $this->assertEquals(3, $trendingBook->count());
        $form = $crawler->selectButton('Login')->form();
        $form['_username'] = 'Amal__York1720';
        $form['_password'] = 'OUC51OZS0OH';
        $client->submit($form);
        $client->request('GET','/User');
        $this->assertResponseIsSuccessful();
    }

    /**
     * @throws \Exception
     */
    public function testRouteHome():void
    {
        $client = static::createClient();

        //retrive the test user
        $crawler = $client->request('GET', '/');
        $form = $crawler->selectButton('Login')->form();
        $form['_username'] = 'Amal__York1720';
        $form['_password'] = 'OUC51OZS0OH';
        $client->submit($form);
        $crawler = $client->followRedirect();
        $lastUsername = $crawler->filter('#last_username');
        $this->assertStringContainsString("Amal__York1720", $lastUsername->text());

        $client->request('GET', '/Home');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('#trending_home', 'Trending This Week');
        $this->assertSelectorTextContains('#nearest','Your nearest library');
        $trendingBook = $crawler->filter("#BookPicTrending_home");
        $this->assertEquals(3,$trendingBook->count());
        $favBook = $crawler->filter("#BookPicFav");
        $this->assertEquals(4, $favBook->count());

    }



    public function testRouteSignUp() : void
    {
        $client = static::createClient();
        // open csv file and load data
        if (($handle = fopen(__DIR__."/mockdata/users_register.csv", "r")) !== FALSE) {

            $headers = fgetcsv($handle, 1000, ",");

            $counter = 0;

            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE && $counter < 6) {
                $crawler = $client->request('GET', '/SignUp');
                $form = $crawler->filter('form[name="sign_up_form"]')->form();
                $form['sign_up_form[avatar]'] = $data[0];
                $curr_username = $data[1];
                $form['sign_up_form[username]'] = $data[1]; //can only used one time in a test, after run once, need to test with unique username
                $curr_pass = $data[2];
                $form['sign_up_form[password][first]'] = $data[2];
                $form['sign_up_form[password][second]'] = $data[2];
                $form['sign_up_form[first_name]'] = $data[3];
                $form['sign_up_form[last_name]'] = $data[4];
                $form['sign_up_form[birthdate][day]'] = $data[5];
                $form['sign_up_form[birthdate][month]'] = $data[6];
                $form['sign_up_form[birthdate][year]'] = $data[7];
                $form['sign_up_form[street]'] = $data[8];
                $form['sign_up_form[house_number]'] = $data[9];
                $form['sign_up_form[postcode]'] = $data[10];
                $form['sign_up_form[terms_and_condition]'] = true;

                $client->submit($form);

                $crawler=$client->followRedirect();

                $form = $crawler->selectButton('Login')->form();
                $form['_username'] = $curr_username;
                $form['_password'] = $curr_pass;
                var_dump($curr_username);
                $client->submit($form);
                $client->request('GET', '/Search');
                $this->assertResponseIsSuccessful();
                $crawler = $client->getCrawler();
                $link = $crawler->selectLink('Logout')->link();
                $client->click($link);

                $counter++;
            }
        }
    }



    /**
     * @throws \Exception
     */
    public function testRouteUser():void{
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);

        //retrive the test user
        $crawler = $client->request('GET', '/');
        $form = $crawler->selectButton('Login')->form();
        $form['_username'] = 'Amal__York1720';
        $form['_password'] = 'OUC51OZS0OH';
        $client->submit($form);
        $crawler = $client->followRedirect();
        $lastUsername = $crawler->filter('#last_username');
        $this->assertStringContainsString("Amal__York1720", $lastUsername->text());

        $client->request('GET', '/User');
        $this->assertResponseIsSuccessful();

        //Check if it displays al the info of the user

        $this->assertSelectorTextContains('#FirstNameUser', 'Amal');
        $this->assertSelectorTextContains('#LastNameUser', 'York');
        $this->assertSelectorTextContains('#DateOfBirthUser', '2007-02-26');
        $this->assertSelectorTextContains('#StreetUser', '3576 Ipsum St.');
        $this->assertSelectorTextContains('#HouseNumberUser', '91');
        $this->assertSelectorTextContains('#PostcodeUser', '8375');
        $this->assertSelectorTextContains('#LibraryUser', 'Curae Inc.');



    }

    /**
     * @throws \Exception
     */
    public function testRouteBook():void
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);

        $crawler = $client->request('GET', '/');
        $form = $crawler->selectButton('Login')->form();
        $form['_username'] = 'Amal__York1720';
        $form['_password'] = 'OUC51OZS0OH';
        $client->submit($form);
        $crawler = $client->followRedirect();
        $lastUsername = $crawler->filter('#last_username');
        $this->assertStringContainsString("Amal__York1720", $lastUsername->text());

        $client->request('GET', '/Book/53');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h2', 'Give review for the book');
        $this->assertSelectorTextContains('#BookAuthor', 'Name Loading');
        $this->assertSelectorTextContains('#BookTitle', 'Title loading');

        /**The test below that is commented out is not working in WebTestCase because the images, title, author, etc is rendered by javascript,
         * should be tested in javascript test*
         */
        /*$crawler = $client->getCrawler();
        $this->assertSelectorTextContains('#BookTitle', 'Dune Messiah');
        $inputBookNameFeedback = $crawler->filter('#book_review_form_book');
        $this->assertSame('Dune Messiah (Dune Chronicles #2)', $inputBookNameFeedback->attr('value'));
        $this->assertSelectorTextContains('h1',' What book lovers say about "Dune Messiah (Dune Chronicles #2)" ? ');
        $form = $crawler->filter('form[name="book_review_form"]')->form();
        $form['book_review_form[text]'] = 'This is a great book!';
        $form['book_review_form[rate]'] = 8;
        $client->submit($form);
        $crawler = $client->followRedirect();
        $this->assertSelectorTextContains('li','This is a great book!');*/




    }


}
