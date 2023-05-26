<?php

namespace App\Tests;

use Symfony\Component\Panther\PantherTestCase;

class SmokeTest extends PantherTestCase
{
    public function testRouteHome():void {
        $client = static::createPantherClient();
        $crawler = $client->request('GET','/Home');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('#trending_home','Trending This Week');
    }

}