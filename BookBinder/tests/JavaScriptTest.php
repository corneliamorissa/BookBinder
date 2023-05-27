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
    }
}
