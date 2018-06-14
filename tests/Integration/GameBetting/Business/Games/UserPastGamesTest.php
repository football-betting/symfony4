<?php


namespace App\Tests\Integration\GameBetting\Business\Games;

use App\GameBetting\Business\Games\UserFutureGames;
use App\GameBetting\Business\Games\UserPastGames;
use App\GameCore\Persistence\Entity\Game;
use App\Tests\Integration\Helper\Games;
use App\Tests\Integration\Helper\User;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserPastGamesTest extends KernelTestCase
{
    use Games, User;

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
        parent::tearDown();

        $this->deleteTestGames();

        $this->entityManager->close();
        $this->entityManager = null;
    }


    public function testPastGame()
    {
        $userPastGames = new UserPastGames(
            $this->entityManager
        );

        $futureTestGame = $this->createTestFutureGames();
        $pastTestGame = $this->createTestPastGames();

        $pastGames = $userPastGames->get($this->getUser());
        $foundFutureGame = false;
        $foundPastGame = false;

        foreach ($pastGames as $gameId => $pastGame) {
            if ($gameId === $futureTestGame->getId()) {
                $foundFutureGame = true;
            }
            if ($gameId === $pastTestGame->getId()) {
                $foundPastGame = true;
            }
        }

        self::assertFalse($foundFutureGame);
        self::assertTrue($foundPastGame);

    }
}