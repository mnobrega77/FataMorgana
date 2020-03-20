<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SecurityControllerTest extends WebTestCase
{
    public function testRegister()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/inscription');

        $this->assertResponseIsSuccessful();

        $button = $crawler->selectButton('Valider');
        $form = $button->form();
        $form['registration[client][nom]']->setValue('Smith');
        $form['registration[client][prenom]']->setValue('Ryan');
        $form['registration[client][adresse]']->setValue('2 rue belleville');
        $form['registration[client][cp]']->setValue('75000');
        $form['registration[client][ville]']->setValue('Paris');
        $form['registration[client][tel]']->setValue('0614147887');
        $form['registration[username]']->setValue('rsmith');
        $form['registration[email]']->setValue(sprintf('foo%s@example.com', rand()));
        $form['registration[password]']->setValue('12345678');
        $form['registration[confirmPassword]']->setValue('12345678');

        $client->submit($form);

        $this->assertResponseRedirects();
    }
}
