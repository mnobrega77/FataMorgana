<?php

namespace App\Tests;

use Symfony\Component\Panther\PantherTestCase;

class MainController2Test extends PantherTestCase
{
    public function testSomething()
    {
        $client = static::createPantherClient(['external_base_uri' => 'https://localhost']);
        $crawler = $client->request('GET', '/livre/ES0100');

        //$this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h6', 'SNOWDEN');
    }
}
