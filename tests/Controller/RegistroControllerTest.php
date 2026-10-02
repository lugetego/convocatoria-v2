<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RegistroControllerTest extends WebTestCase
{
    public function testNewFormIsDisplayed(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/registro/new');

        self::assertResponseIsSuccessful();
        self::assertCount(1, $crawler->filter('form'));
        self::assertCount(5, $crawler->filter('input[type="file"]'));
        self::assertGreaterThan(0, $crawler->filter('input[name$="[ref1nombre]"]')->count());
        self::assertGreaterThan(0, $crawler->filter('input[name$="[ref2nombre]"]')->count());
    }

    public function testEmptySubmissionShowsValidationErrors(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/registro/new');
        $form = $crawler->filter('form')->form();

        $client->submit($form);

        self::assertResponseIsSuccessful();
        self::assertSelectorExists('.text-danger');
    }
}
