<?php

namespace App\Tests;

use App\Repository\UserRepository;
use DateTime;
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
        $crawler = $client->request('GET', '/SignUp');
        //$form['form[avatar]'] = $crawler->selectImage('2');
        $form = $crawler->filter('form[name="signup"]')->form();
        $form['sign_up_form[avatar]'] = 2;
        $form['sign_up_form[username]'] = 'Becky_Jrcf2hj'; //can only used one time in a test, after run once, need to test with unique username
        $form['sign_up_form[password][first]'] = 'Secretf678';
        $form['sign_up_form[password][second]'] = 'Secretf678';
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
        $crawler = $client->followRedirect();
        $form = $crawler->selectButton('Login')->form();
        $form['_username'] = 'Becky_J';
        $form['_password'] = 'Secret678';
        $client->submit($form);
        $client->request('GET', '/Search');
        $this->assertResponseIsSuccessful();


    }
}
