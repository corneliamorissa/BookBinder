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
        $trendingBook = $crawler->filter('#BookPic');
        $this->assertEquals(3, $trendingBook->count());
        $form = $crawler->selectButton('Login')->form();
        $form['_username'] = 'Amal__York1720';
        $form['_password'] = 'OUC51OZS0OH';
        $client->submit($form);
        $client->request('GET','/User');
        $this->assertResponseIsSuccessful();
    }

    /*public function testRouteHome():void
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);

        //retrive the test user
        $testUser = $userRepository->findOneBy(['username'=> 'Amal__York1720']);

        //simulate $testUser being logged in
        $client->loginUser($testUser);

        //test the home page rout if its rendered the right html file
        $client->request('GET', 'Home');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('#trending_home', 'Trending This Week');
        $this->assertSelectorTextContains('#nearest','Your nearest library');
    }*/

}
