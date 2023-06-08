<?php

namespace App\Tests;

use Facebook\WebDriver\Exception\NoSuchElementException;
use Facebook\WebDriver\Exception\TimeoutException;
use PHPUnit\Framework\AssertionFailedError;
use Symfony\Component\Panther\PantherTestCase;
use Symfony\Component\Panther\Client;
//when testing check if chrome driver is running in background, if it is, end the task in task manager, and run test again
class JavaScriptTest extends PantherTestCase
{
    /**
     * @throws NoSuchElementException
     * @throws TimeoutException
     */
    public function testUserAlreadyExists(): void
    {
        $client = static::createPantherClient([
            'port' => 8080, // Defaults to 9080
        ]);
        $crawler = $client->request('GET', '/SignUp');
        $crawler->filter('.test')->sendKeys('Amal__York1720');
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
        $retryCount = 5;
        $isTestPassed = false;
        $client = static::createPantherClient();
        $crawler = $client->request('GET', '/');

        // Put user credentials to pass the login authentication
        $form = $crawler->selectButton('Login')->form();
        $form['_username'] = 'Amal__York1720';
        $form['_password'] = 'OUC51OZS0OH';
        $client->submit($form);
        $client->request('GET', '/Home');

        while ($retryCount > 0 && !$isTestPassed) {
            try {
                // Wait for the book cover images to be updated
                $client->wait(240000, function () use ($client) {
                    sleep(10);
                    $crawler = $client->getCrawler();
                    $bookImagesCount = $crawler->filter('.BookPicTrending_home[src!="/public/assets/no_cover.jpg"]')->count();
                    $expectedBookImagesCount = count($crawler->filter('.BookPicTrending_home'));
                    return $bookImagesCount === $expectedBookImagesCount;
                });

                // Assert the updated book cover image
                $crawler = $client->getCrawler();
                $bookImage = $crawler->filter('.BookPicTrending_home')->first();
                $expectedImageUrl = 'https://covers.openlibrary.org/b/id/6389112-L.jpg'; // Update with the expected image URL
                $this->assertSame($expectedImageUrl, $bookImage->attr('src'));

                // Set the test as passed if no exceptions were thrown
                $isTestPassed = true;
            } catch (AssertionFailedError $e) {
                // Retry the test if AssertionFailedError occurs
                $retryCount--;
            }
        }

        // Assert if the test eventually passed
        $this->assertTrue($isTestPassed);

        $client->quit();
    }


    /**
     * @throws NoSuchElementException
     * @throws TimeoutException
     * @throws \Exception
     */
    public function testFaveBookJavascriptByIsbn(): void
    {

        $retryCount = 10;
        $isTestPassed = false;

        $client = static::createPantherClient();
        $crawler = $client->request('GET', '/');

        // Put user credentials to pass the login authentication
        $form = $crawler->selectButton('submit_login')->form();
        $form['_username'] = 'Amal__York1720';
        $form['_password'] = 'OUC51OZS0OH';
        $client->submit($form);
        $client->request('GET', '/Home');


        while ($retryCount > 0 && !$isTestPassed) {
            try {
                /// Wait for the book cover images to be updated
                $client->wait(360000, function () use ($client) {
                    sleep(10);

                    $crawler = $client->getCrawler();
                    $bookImagesCount = $crawler->filter('.BookPicFav[src!="/public/assets/no_cover.jpg"]')->count();
                    $expectedBookImagesCount = count($crawler->filter('.BookPicFav'));
                    return $bookImagesCount === $expectedBookImagesCount;
                });

                // Assert the updated book cover image
                $crawler = $client->getCrawler();
                $bookImage = $crawler->filter('.BookPicFav')->first();
                $expectedImageUrl = 'https://covers.openlibrary.org/b/id/12701394-L.jpg'; // Update with the expected image URL
                $this->assertSame($expectedImageUrl, $bookImage->attr('src'));

                // Set the test as passed if no exceptions were thrown
                $isTestPassed = true;
            } catch (AssertionFailedError $e) {
                // Retry the test if AssertionFailedError occurs
                $retryCount--;
            }
        }

        // Assert if the test eventually passed
        $this->assertTrue($isTestPassed);




        $this->takeScreenshotIfTestFailed();
        $client->quit();
    }

}
