<?php

namespace App\User\Communication\Controller;

use App\Tests\Integration\Helper\Config;
use App\Tests\Integration\Helper\User;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Client;

class SecurityTest extends WebTestCase
{
    use User;
    /**
     * @var Client
     */
    protected $client;

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    protected function setUp()
    {
        $this->client = self::createClient();
        $this->entityManager = $this->client->getContainer()->get('doctrine')->getManager();
        $this->getUser();
    }

    protected function tearDown()
    {
        $this->deleteUserByUsername(Config::USER_NAME);
        $this->entityManager->close();
        $this->entityManager = null;
    }

    public function testLoginFormExists(): void
    {
        $this->client->request('GET', '/');

        $this->assertContains(
            '_username',
            $this->client->getResponse()->getContent()
        );
        $this->assertContains(
            '_password',
            $this->client->getResponse()->getContent()
        );
    }

    public function testLoginSuccess(): void
    {
        $crawler = $this->client->request('GET', '/');

        $form = $crawler->selectButton('login')->form();
        $form['_username'] = Config::USER_NAME;
        $form['_password'] = Config::USER_PASS;

        $this->client->submit($form);
        $this->client->followRedirect();

        $this->assertContains('gamebet', $this->client->getHistory()->current()->getUri());
    }

    public function testLoginErrorMessage(): void
    {
        $crawler = $this->client->request('GET', '/');

        $form = $crawler->selectButton('login')->form();
        $form['_username'] = 'FAIL_USER';
        $form['_password'] = 'FAILED';

        $this->client->submit($form);
        $this->client->followRedirect();

        $this->assertContains('Invalid credentials.', $this->client->getResponse()->getContent());
    }
}
