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
        $trending_book = $crawler->filter('.bookdetails'); //because 3 trending book, book details is 3 each book, so 9 should be expected
        $this->assertEquals(9, $trending_book->count());
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
        $last_username = $crawler->filter('#last_username');
        $this->assertStringContainsString("Amal__York1720", $last_username->text());

        $client->request('GET', '/Home');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('#trending_home', 'Trending This Week');
        $this->assertSelectorTextContains('#nearest','Your nearest library');
        $trending_book = $crawler->filter("#BookPicTrending_home");
        $this->assertEquals(3,$trending_book->count());
        $fav_book = $crawler->filter("#BookPicFav");
        $this->assertEquals(4, $fav_book->count());

    }


    /**
     * @throws \Exception
     */
    public function testRouteSignUp() : void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/SignUp');
        //$form['form[avatar]'] = $crawler->selectImage('2');
        $form = $crawler->filter('form[name="signup"]')->form();
        $form['sign_up_form[avatar]'] = 8;

        // Generate a random username bcs there is authentication that username needs to be random
        $baseUsername = 'test'; // Base username
        $randomString = bin2hex(random_bytes(4)); // Generate a random string
        $randomUsername = $baseUsername . '_' . $randomString; // Combine base username and random string
        $form['sign_up_form[username]'] = $randomUsername;

        var_dump($randomUsername);

        //static info for test purposes
        $form['sign_up_form[password][first]'] = 'Secret678';
        $form['sign_up_form[password][second]'] = 'Secret678';
        $form['sign_up_form[first_name]'] = 'Test Purposes';
        $form['sign_up_form[last_name]'] = 'UtilTest';
        $form['sign_up_form[birthdate][month]'] = 10;
        $form['sign_up_form[birthdate][day]'] = 19;
        $form['sign_up_form[birthdate][year]'] = 2006;
        $form['sign_up_form[street]'] = 'NewMiles South';
        $form['sign_up_form[house_number]'] = 34;
        $form['sign_up_form[postcode]'] = 3232;
        $form['sign_up_form[terms_and_condition]'] = true;

        $client->submit($form);

        $crawler = $client->followRedirect();
        $form = $crawler->selectButton('Login')->form();
        $form['_username'] = $randomUsername;
        $form['_password'] = 'Secret678';
        $client->submit($form);
        $this->assertResponseStatusCodeSame(302);
    }


    public function testErrorMessageRepeatedPasswordNotMatch()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/SignUp');
        $form = $crawler->filter('form[name="sign_up_form"]')->form();
        $form['sign_up_form[avatar]'] = 2;
        $form['sign_up_form[username]'] = 'Becky_Jhj'; //can only used one time in a test, after run once, need to test with unique username
        $form['sign_up_form[password][first]'] = 'Secret678';
        $form['sign_up_form[password][second]'] = 'Secret8';
        $form['sign_up_form[first_name]'] = 'Becky';
        $form['sign_up_form[last_name]'] = 'Jessica';
        $form['sign_up_form[birthdate][month]'] = 10;
        $form['sign_up_form[birthdate][day]'] = 19;
        $form['sign_up_form[birthdate][year]'] = 2006;
        $form['sign_up_form[street]'] = 'NewMiles South';
        $form['sign_up_form[house_number]'] = 34;
        $form['sign_up_form[postcode]'] = 3232;
        $form['sign_up_form[terms_and_condition]'] = true;

        $client->submit($form);
        $crawler = $client->getCrawler();
        $error_message_not_match = $crawler->filter('ul li')->text();
        $this->assertEquals('The values do not match.', $error_message_not_match);
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
        $last_username = $crawler->filter('#last_username');
        $this->assertStringContainsString("Amal__York1720", $last_username->text());

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
        $last_username = $crawler->filter('#last_username');
        $this->assertStringContainsString("Amal__York1720", $last_username->text());

        $client->request('GET', '/Book/53');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h2', 'Give review for the book');
        $this->assertSelectorTextContains('#BookAuthor', 'Name Loading');
        $this->assertSelectorTextContains('#BookTitle', 'Title loading');

    }


}
