<?php

namespace App\Tests;

use App\Repository\UserRepository;
use Symfony\Component\Panther\PantherTestCaseTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\MockArraySessionStorage;

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

    public function testRouteErrorMessageWrongPassLogin(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        $this->assertResponseIsSuccessful();

        $form = $crawler->selectButton('Login')->form();
        $form['_username'] = 'Amal__York1720';
        $form['_password'] = 'OUCS0OH';
        $client->submit($form);
        $client->followRedirect();
        $crawler = $client->getCrawler();
        $error_message_wrong_pass = $crawler->filter('#flash')->text();
        $this->assertEquals('Invalid credentials.', $error_message_wrong_pass);

    }


    public function testRouteErrorMessageWrongUsernameLogin(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        $this->assertResponseIsSuccessful();

        $form = $crawler->selectButton('Login')->form();
        $form['_username'] = 'Amalrk1720';
        $form['_password'] = 'OUC51OZS0OH';
        $client->submit($form);
        $client->followRedirect();
        $crawler = $client->getCrawler();
        $error_message_wrong_pass = $crawler->filter('#flash')->text();
        $this->assertEquals('Invalid credentials.', $error_message_wrong_pass);

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
       /* $last_username = $crawler->filter('#last_username');
        $this->assertStringContainsString("Amal__York1720", $last_username->text());*/

        $client->request('GET', '/Home');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('#trending_home', 'Trending This Week');
        $this->assertSelectorTextContains('#nearest','Your nearest library');
        $trending_book = $crawler->filter(".BookPicTrending_home");
        $this->assertEquals(3,$trending_book->count());
        $fav_book = $crawler->filter(".BookPicFav");
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
        $form['sign_up_form[last_name]'] = 'UtilTests';
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


    public function testErrorMessageIntegerType()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/SignUp');
        $form = $crawler->filter('form[name="sign_up_form"]')->form();
        $form['sign_up_form[avatar]'] = 2;
        $form['sign_up_form[username]'] = 'Becky_Jhj'; //can only used one time in a test, after run once, need to test with unique username
        $form['sign_up_form[password][first]'] = 'Secret678';
        $form['sign_up_form[password][second]'] = 'Secret678';
        $form['sign_up_form[first_name]'] = 'Becky';
        $form['sign_up_form[last_name]'] = 'Jessica';
        $form['sign_up_form[birthdate][month]'] = 10;
        $form['sign_up_form[birthdate][day]'] = 19;
        $form['sign_up_form[birthdate][year]'] = 2006;
        $form['sign_up_form[street]'] = 'NewMiles South';
        $form['sign_up_form[house_number]'] = 'hebd';
        $form['sign_up_form[postcode]'] = 'gve';
        $form['sign_up_form[terms_and_condition]'] = true;

        $client->submit($form);
        $crawler = $client->getCrawler();
        $error_message_not_match = $crawler->filter('ul li')->text();
        $error_count = $crawler->filter('ul li')->count();
        $this->assertEquals('Please enter a number.', $error_message_not_match);
        $this->assertEquals(2, $error_count);
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
       /* $last_username = $crawler->filter('#last_username');
        $this->assertStringContainsString("Amal__York1720", $last_username->text());*/

        $client->request('GET', '/User');
        $this->assertResponseIsSuccessful();

        //Check if it displays al the info of the user

        $this->assertSelectorTextContains('#first_name_user', 'Amal');
        $this->assertSelectorTextContains('#last_name_user', 'York');
        $this->assertSelectorTextContains('#date_of_birth_user', '2007-02-26');
        $this->assertSelectorTextContains('#street_user', '3576 Ipsum St.');
        $this->assertSelectorTextContains('#house_number_user', '91');
        $this->assertSelectorTextContains('#postcode_user', '8375');
        $this->assertSelectorTextContains('#library_user', 'Curae Inc.');



    }

    /**
     * @throws \Exception
     */
    public function testRouteBook():void
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');
        $form = $crawler->selectButton('Login')->form();
        $form['_username'] = 'Amal__York1720';
        $form['_password'] = 'OUC51OZS0OH';
        $client->submit($form);
        $crawler = $client->followRedirect();
        /*$last_username = $crawler->filter('.loggedin_user');
        $this->assertStringContainsString("Amal__York1720", $last_username->text());*/

        $client->request('GET', '/Book/53');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h2', 'Give review for the book');
        $this->assertSelectorTextContains('#BookAuthor', 'Name Loading');
        $this->assertSelectorTextContains('#BookTitle', 'Title loading');

    }



    public function testRouteLogout(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        $this->assertResponseIsSuccessful();
        $form = $crawler->selectButton('Login')->form();
        $form['_username'] = 'Amal__York1720';
        $form['_password'] = 'OUC51OZS0OH';
        $client->submit($form);
        //to see if user pass the authentication
        $client->request('GET','/MeetUp');
        $this->assertResponseIsSuccessful();
        //click on logout
        $client->clickLink('Logout');
        $client->followRedirect();
        $crawler = $client->getCrawler();
        //login property to check after click Logout user get back to the login page
        $trending_book = $crawler->filter('.bookdetails');
        $this->assertEquals(9, $trending_book->count());
    }

    /**
     * @throws \Exception
     */
    public function testRouteSearch():void
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');
        $form = $crawler->selectButton('Login')->form();
        $form['_username'] = 'Amal__York1720';
        $form['_password'] = 'OUC51OZS0OH';
        $client->submit($form);
        $crawler = $client->followRedirect();
       /* $last_username = $crawler->filter('#last_username');
        $this->assertStringContainsString("Amal__York1720", $last_username->text());*/

        $client->request('GET', '/Search');
        $this->assertResponseIsSuccessful();
        // $this->assertSelectorTextContains('h1', 'Book Search');
        $this->assertSelectorTextContains('h2', 'Enter the ISBN of the book you want to find');

        $crawler = $client->getCrawler();
        //isbn = 9780439358071 && Harry Potter and the Order of the Phoenix (Harry Potter  #5)
        // Set the value of the input field
        $session = new Session(new MockArraySessionStorage());
        $session->set('_security_main', serialize($client->getContainer()->get('security.token_storage')->getToken()));
        $client->getContainer()->set('session', $session);

        $client->request('POST', '/Search', ['isbn' => '9780439358071']);
        $this->assertResponseIsSuccessful();
    }

    /**
     * @throws \Exception
     */
    public function testRouteMeetUp():void
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');
        $form = $crawler->selectButton('Login')->form();
        $form['_username'] = 'Amal__York1720';
        $form['_password'] = 'OUC51OZS0OH';
        $client->submit($form);
        $crawler = $client->followRedirect();
       /* $last_username = $crawler->filter('#last_username');
        $this->assertStringContainsString("Amal__York1720", $last_username->text());*/

        $client->request('GET', '/MeetUp');
        $this->assertResponseIsSuccessful();

        $crawler = $client->getCrawler();
        $container = $crawler->filter('.booklovers-container'); //because 3 trending book, book details is 3 each book, so 9 should be expected
        $this->assertEquals(2, $container->count());

        $card_body = $crawler->filter('.card-body'); //because 3 trending book, book details is 3 each book, so 9 should be expected
        $this->assertEquals(3, $card_body->count());

    }



}
