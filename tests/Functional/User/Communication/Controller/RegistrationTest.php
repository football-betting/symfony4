<?php

namespace App\User\Communication\Controller;

use App\Tests\Integration\Helper\Config;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Client;
use Symfony\Component\DomCrawler\Crawler;

class RegistrationTest extends WebTestCase
{

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
    protected $registerRequest;

    protected function setUp()
    {
        $this->client = self::createClient();
        $this->registerRequest = $this->client->request('GET', '/register');
        $this->entityManager = $this->client->getContainer()->get('doctrine')->getManager();
    }

    protected function tearDown()
    {
        $sql = 'DELETE FROM app_users WHERE username = "'.Config::USER_NAME_TWO.'"';
        $this->entityManager->getConnection()->prepare($sql)->execute();

        $this->entityManager->close();
        $this->entityManager = null;
    }

    /**
     * @dataProvider inputProvider
     * @param $input
     */
    public function testRegisterFormExists($input)
    {
        $this->registerRequest;

        $this->assertContains(
            $input,
            $this->client->getResponse()->getContent()
        );
    }

    public function testRegister()
    {
        $crawler = $this->registerRequest;

        $form = $crawler->selectButton('Registrieren!')->form();
        $form['user[username]'] = Config::USER_NAME_TWO;
        $form['user[email]'] = Config::USER_EMAIL_TWO;
        $form['user[plainPassword][first]'] = Config::USER_PASS_TWO;
        $form['user[plainPassword][second]'] = Config::USER_PASS_TWO;

        $this->client->submit($form);
        $this->client->followRedirect();

        $query = $this->entityManager->createQuery(
            'SELECT u FROM App\User\Persistence\Entity\User u WHERE u.username = :name');
        $query->setParameter('name', Config::USER_NAME_TWO);
        $users = $query->getResult(2); // array of ForumUser objects

        $this->assertNotEmpty($users);
        $this->assertContains('Login', $this->client->getResponse()->getContent());
    }

    /**
     * @return \Generator
     */
    public function inputProvider(): ?\Generator
    {
        yield ['user[username]'];
        yield ['user[email]'];
        yield ['user[plainPassword][first]'];
        yield ['user[plainPassword][second]'];
    }
}
