<?php


namespace App\Tests\Integration\GameRating\Business;

use App\GameRating\Business\GameRatingFacadeInterface;
use App\Tests\Integration\Helper\Games;
use App\Tests\Integration\Helper\User;
use App\Tests\Integration\Helper\UserGames;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class GameRatingFacadeTest extends KernelTestCase
{
    use Games, User, UserGames;

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;


    /**
     * {@inheritDoc}
     */
    protected function setUp()
    {
        $kernel = self::bootKernel();
        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    protected function tearDown()
    {
        $this->deleteTestUserGames();
        $this->deleteTestGames();

        parent::tearDown();

        $this->entityManager->close();
        $this->entityManager = null;
    }

    public function testGetUserScoreWithPosition()
    {
        $this->createTestPastGamesUserGames();
        $this->createTestPastGamesUserGamesTwo();
        /** @var GameRatingFacadeInterface $gameRatingFacade */
        $gameRatingFacade = self::$container->get('App\GameRating\Business\GameRatingFacade');
        $scoring = $gameRatingFacade->getUserScoreWithPosition();

        $this->assertSame(1, $scoring[0]->getPosition());
        $this->assertSame($this->getUser()->getUsername(), $scoring[0]->getUserScore()->getUser()->getUsername());

        $this->assertSame(2, $scoring[1]->getPosition());
        $this->assertSame($this->getUserTwo()->getUsername(), $scoring[1]->getUserScore()->getUser()->getUsername());
    }
}