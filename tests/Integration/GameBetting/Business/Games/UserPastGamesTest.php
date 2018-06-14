<?php


namespace App\Tests\Integration\GameBetting\Business\Games;

use App\GameBetting\Business\Games\UserFutureGames;
use App\GameBetting\Business\Games\UserPastGames;
use App\GameCore\Persistence\Entity\Game;
use App\GameRating\Business\GameRatingFacadeInterface;
use App\Tests\Integration\Helper\Games;
use App\Tests\Integration\Helper\User;
use App\Tests\Integration\Helper\UserGames;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserPastGamesTest extends KernelTestCase
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


    public function testPastGame()
    {
        $mockGameRatingFacade = $this->createMock(GameRatingFacadeInterface::class);

        $mockGameRatingFacade->method('getPoints')
            ->willReturn(1);

        $userPastGames = new UserPastGames(
            $this->entityManager,
            $mockGameRatingFacade
        );

        $futureTestGame = $this->createTestFutureGames();
        $futureTestGameSecond = $this->createTestFutureGamesSecond();
        $pastTestGame = $this->createTestPastGames();
        $pastTestGameSecond = $this->createTestPastGamesSecond();

        $pastGames = $userPastGames->get($this->getUser());
        $foundFutureGame = false;
        $foundFutureGameSecond = false;
        $foundPastGame = false;
        $foundPastGameSecond = false;

        foreach ($pastGames as $gameId => $pastGame) {
            if ($gameId === $futureTestGame->getId()) {
                $foundFutureGame = true;
            }
            if ($gameId === $futureTestGameSecond->getId()) {
                $foundFutureGameSecond = true;
            }
            if ($gameId === $pastTestGame->getId()) {
                $foundPastGame = true;
            }
            if ($gameId === $pastTestGameSecond->getId()) {
                $foundPastGameSecond = true;
            }
        }

        self::assertFalse($foundFutureGame);
        self::assertFalse($foundFutureGameSecond);
        self::assertTrue($foundPastGame);
        self::assertTrue($foundPastGameSecond);

    }

    public function testPastGameWithUserBetting()
    {
        $mockGameRatingFacade = $this->createMock(GameRatingFacadeInterface::class);

        $mockGameRatingFacade->method('getPoints')
                ->willReturn(55);

        $userPastGames = new UserPastGames(
            $this->entityManager,
            $mockGameRatingFacade
        );

        $futureTestUserGame = $this->createTestFutureGamesUserGames();
        $futureTestGame = $futureTestUserGame->getGame();
        $futureTestGameSecond = $this->createTestFutureGamesSecond();
        $pastTestUserGame = $this->createTestPastGamesUserGames();
        $pastTestGame = $pastTestUserGame->getGame();
        $pastTestGameSecond = $this->createTestPastGamesSecond();

        $pastGames = $userPastGames->get($this->getUser());
        $foundFutureGame = false;
        $foundFutureGameSecond = false;
        $foundPastGame = false;
        $foundPastGameSecond = false;

        foreach ($pastGames as $gameId => $pastGame) {
            if ($gameId === $futureTestGame->getId()) {
                $foundFutureGame = true;
            }
            if ($gameId === $futureTestGameSecond->getId()) {
                $foundFutureGameSecond = true;
            }
            if ($gameId === $pastTestGame->getId()) {
                $foundPastGame = true;
                self::assertSame(4, $pastGame->getFirstTeamUserResult());
                self::assertSame(5, $pastGame->getSecondTeamUserResult());
                self::assertSame(55, $pastGame->getScore());
            }
            if ($gameId === $pastTestGameSecond->getId()) {
                $foundPastGameSecond = true;
            }
        }

        self::assertFalse($foundFutureGame);
        self::assertFalse($foundFutureGameSecond);
        self::assertTrue($foundPastGame);
        self::assertTrue($foundPastGameSecond);

    }
}