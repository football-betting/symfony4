<?php


namespace App\Tests\Integration\GameBetting\Business\Games;

use App\GameBetting\Business\Games\UserFutureGames;
use App\GameCore\Persistence\Entity\Game;
use App\Tests\Integration\Helper\Games;
use App\Tests\Integration\Helper\User;
use App\Tests\Integration\Helper\UserGames;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserFutureGamesTest extends KernelTestCase
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
        parent::tearDown();

        $this->deleteTestUserGames();
        $this->deleteTestGames();

        $this->entityManager->close();
        $this->entityManager = null;
    }


    public function testFutureGame()
    {
        $userFutureGames = new UserFutureGames(
            $this->entityManager
        );

        $futureTestGame = $this->createTestFutureGames();
        $futureTestGameSecond = $this->createTestFutureGamesSecond();
        $pastTestGame = $this->createTestPastGames();
        $pastTestGameSecond = $this->createTestPastGamesSecond();


        $futureGames = $userFutureGames->get($this->getUser());

        $foundFutureGame = false;
        $foundFutureGameSecond = false;
        $foundPastGame = false;
        $foundPastGameSecond = false;

        foreach ($futureGames as $futureGame) {
            /** @var Game $game */
            $game = $futureGame['game'];
            if ($game->getId() === $futureTestGame->getId()) {
                $foundFutureGame = true;
            }
            if ($game->getId() === $futureTestGameSecond->getId()) {
                $foundFutureGameSecond = true;
            }
            if ($game->getId() === $pastTestGame->getId()) {
                $foundPastGame = true;
            }
            if ($game->getId() === $pastTestGameSecond->getId()) {
                $foundPastGameSecond = true;
            }
        }

        self::assertTrue($foundFutureGame);
        self::assertTrue($foundFutureGameSecond);
        self::assertFalse($foundPastGame);
        self::assertFalse($foundPastGameSecond);
    }


    public function testFutureGameWithUserBet()
    {
        $userFutureGames = new UserFutureGames(
            $this->entityManager
        );

        $futureTestUserGame = $this->createTestFutureGamesUserGames();
        $futureTestGame = $futureTestUserGame->getGame();
        $futureTestGameSecond = $this->createTestFutureGamesSecond();
        $pastTestUserGame = $this->createTestPastGamesUserGames();
        $pastTestGame = $pastTestUserGame->getGame();
        $pastTestGameSecond = $this->createTestPastGamesSecond();


        $futureGames = $userFutureGames->get($this->getUser());

        $foundFutureGame = false;
        $foundFutureGameSecond = false;
        $foundPastGame = false;
        $foundPastGameSecond = false;

        foreach ($futureGames as $futureGame) {
            /** @var Game $game */
            $game = $futureGame['game'];
            if ($game->getId() === $futureTestGame->getId()) {
                $foundFutureGame = true;
                self::assertSame(4, $futureGame['bet']->getFirstTeamResult());
                self::assertSame(5, $futureGame['bet']->getSecondTeamResult());
            }
            if ($game->getId() === $futureTestGameSecond->getId()) {
                $foundFutureGameSecond = true;
            }
            if ($game->getId() === $pastTestGame->getId()) {
                $foundPastGame = true;
            }
            if ($game->getId() === $pastTestGameSecond->getId()) {
                $foundPastGameSecond = true;
            }
        }

        self::assertTrue($foundFutureGame);
        self::assertTrue($foundFutureGameSecond);
        self::assertFalse($foundPastGame);
        self::assertFalse($foundPastGameSecond);
    }
}