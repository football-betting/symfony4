<?php

namespace App\User\Communication\Controller;

use App\Tests\Integration\Helper\Config;
use App\Tests\Integration\Helper\User;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Client;
use Symfony\Component\DomCrawler\Crawler;

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

    /**
     * @var Crawler
     */
    protected $loginRequest;

    protected function setUp()
    {
        $this->client = self::createClient();
        $this->loginRequest = $this->client->request('GET', '/');
        $this->entityManager = $this->client->getContainer()->get('doctrine')->getManager();
        $this->getUser();
    }

    protected function tearDown()
    {
        $this->entityManager->close();
        $this->entityManager = null;
    }

    public function testLoginFormExists(): void
    {
        $this->loginRequest;

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
        $crawler = $this->loginRequest;

        $form = $crawler->selectButton('login')->form();
        $form['_username'] = Config::USER_NAME;
        $form['_password'] = Config::USER_PASS;

        $this->client->submit($form);
        $this->client->followRedirect();

        $this->assertContains('gamebet', $this->client->getHistory()->current()->getUri());
    }

    public function testLoginErrorMessage(): void
    {
        $crawler = $this->loginRequest;

        $form = $crawler->selectButton('login')->form();
        $form['_username'] = 'FAIL_USER';
        $form['_password'] = 'FAILED';

        $this->client->submit($form);
        $this->client->followRedirect();

        $this->assertContains('Invalid credentials.', $this->client->getResponse()->getContent());
    }
}
