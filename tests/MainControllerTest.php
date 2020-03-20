<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MainControllerTest extends WebTestCase
{
    public function testShowCat()
    {
        // The createClient() method returns a client, which is like a browser that you'll use to crawl your site

        $client = static::createClient();

        // The request() method returns a Crawler object which can be used to select elements in the response, click on links and submit forms.

        $crawler = $client->request('GET', '/livre/ES0100');

        // $this->assertEquals(200, $client->getResponse()->getStatusCode());

        // The assertResponseIsSuccessful() method is a helper assertion from Symfony that will make sure the response wasn't an error or a redirect.

        $this->assertResponseIsSuccessful();

        $this->assertSelectorTextContains('h6', 'SNOWDEN');
    }
}
