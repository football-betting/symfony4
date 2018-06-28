<?php

namespace App\User\Communication\Controller;

use App\Tests\Integration\Helper\Config;
use App\Tests\Integration\Helper\User;
use App\User\Persistence\Entity\User as UserEntity;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Client;
use Symfony\Component\DomCrawler\Crawler;

class RegistrationTest extends WebTestCase
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
    }

    protected function tearDown()
    {
        $this->deleteUserByUsername(Config::USER_NAME_TWO);
        $this->entityManager->close();
        $this->entityManager = null;
    }

    /**
     * @dataProvider inputProvider
     * @param $input
     */
    public function testRegisterFormExists($input): void
    {
        $this->client->request('GET', '/register');

        $this->assertContains(
            $input,
            $this->client->getResponse()->getContent()
        );
    }

    /**
     * @return Crawler
     */
    public function testRegisterSuccess(): Crawler
    {
        $crawler = $this->client->request('GET', '/register');

        $this->submitRegisterForm($crawler);

        $userRepository = $this->entityManager->getRepository(UserEntity::class);
        $user = $userRepository->loadUserByUsername(Config::USER_NAME_TWO);

        $this->assertNotEmpty($user);
        $this->assertTrue(
            $this->client->getResponse()->isRedirect('/')
        );

        return $crawler;
    }

    public function testUsernameAlreadyTakenError(): void
    {
        $crawler = $this->client->request('GET', '/register');
        $this->submitRegisterForm($crawler);
        $this->submitRegisterForm($crawler);

        $this->assertContains('form-error-message', $this->client->getResponse()->getContent());
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

    /**
     * @param $crawler
     */
    protected function submitRegisterForm($crawler): void
    {
        $form = $crawler->selectButton('Registrieren!')->form();
        $form['user[username]'] = Config::USER_NAME_TWO;
        $form['user[email]'] = Config::USER_EMAIL_TWO;
        $form['user[plainPassword][first]'] = Config::USER_PASS_TWO;
        $form['user[plainPassword][second]'] = Config::USER_PASS_TWO;

        $this->client->submit($form);
    }
}
