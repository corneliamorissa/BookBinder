<?php

namespace App\Tests;

use Facebook\WebDriver\Exception\NoSuchElementException;
use Facebook\WebDriver\Exception\TimeoutException;
use Symfony\Component\Panther\PantherTestCase;
//when testing check if chrome driver is running in background, if it is, end the task in task manager, and run test again
class JavaScriptTest extends PantherTestCase
{
    /**
     * @throws NoSuchElementException
     * @throws TimeoutException
     */
    public function testUserAlreadyExists(): void
    {
        $client = static::createPantherClient();
        $crawler = $client->request('GET', '/SignUp');

        $crawler->filter('#sign_up_form_username')->sendKeys('Amal__York1720');
        $crawler->filter('body')->click(); //AJAX request is onChange, so exit the input field

        $client->waitForElementToContain('#message_check','Username already exist',5);

        $this->assertSelectorTextContains('#message_check', 'Username already exist');
        $this->takeScreenshotIfTestFailed();
        $client->quit();

        $client = static::createPantherClient();
        $crawler = $client->request('GET', '/SignUp');

        $crawler->filter('#sign_up_form_username')->sendKeys('Becky_J');
        $crawler->filter('body')->click(); //AJAX request is onChange, so exit the input field

        $client->waitForElementToContain('#message_check','Username already exist',5);

        $this->assertSelectorTextContains('#message_check', 'Username already exist');
        $this->takeScreenshotIfTestFailed();
        $client->quit();
    }

    /**
     * @throws NoSuchElementException
     * @throws TimeoutException
     * @throws \Exception
     */
    public function testTrendingBookJavascriptByIsbn(): void
    {
        $client = static::createPantherClient();
        $crawler = $client->request('GET', '/');

        // Put user credentials to pass the login authentication
        $form = $crawler->selectButton('Login')->form();
        $form['_username'] = 'Amal__York1720';
        $form['_password'] = 'OUC51OZS0OH';
        $client->submit($form);
        $client->request('GET', '/Home');

        // Wait for the book cover images to be updated
        $client->wait(5000, function () use ($client) {
            $crawler = $client->getCrawler();
            $bookImagesCount = $crawler->filter('.rounded-3.w-50.book-image[src!="/public/assets/no_cover.jpg"]')->count();
            $expectedBookImagesCount = 3;
            return $bookImagesCount === $expectedBookImagesCount;
        });

        // Assert the updated book cover image
        $crawler = $client->getCrawler();
        $bookImage = $crawler->filter('#BookPicTrending_home[data-isbn]')->first();
        $expectedImageUrl = 'https://covers.openlibrary.org/b/id/6389112-L.jpg'; // Update with the expected image URL
        $this->assertSame($expectedImageUrl, $bookImage->attr('src'));

        $this->takeScreenshotIfTestFailed();
        $client->quit();
    }



}
