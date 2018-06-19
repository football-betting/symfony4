<?php


namespace App\Tests\Integration\GameBetting\Business\Games;

use App\GameBetting\Business\GamePoints\PointsInterface;
use App\GameBetting\Business\Games\UserPastGames;
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
        $this->deleteTestUserGames();
        $this->deleteTestGames();

        parent::tearDown();

        $this->entityManager->close();
        $this->entityManager = null;
    }


    public function testPastGame()
    {
        $mockGameRatingFacade = $this->createMock(PointsInterface::class);

        $mockGameRatingFacade->method('get')
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
        $mockGameRatingFacade = $this->createMock(PointsInterface::class);

        $mockGameRatingFacade->method('get')
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

    public function testActiveGame()
    {
        $mockGameRatingFacade = $this->createMock(PointsInterface::class);

        $mockGameRatingFacade->method('get')
            ->willReturn(10);

        $userPastGames = new UserPastGames(
            $this->entityManager,
            $mockGameRatingFacade
        );

        $pastTestGameNotActive = $this->createTestPastGamesNotActive();
        $futureTestGameSecond = $this->createTestFutureGamesSecond();
        $pastTestUserGame = $this->createTestPastGamesUserGames();
        $pastTestGame = $pastTestUserGame->getGame();
        $pastTestGameSecond = $this->createTestPastGamesSecond();

        $pastGames = $userPastGames->getActiveGames($this->getUser());
        $foundFutureGame = false;
        $foundFutureGameSecond = false;
        $foundPastGame = false;
        $foundPastGameSecond = false;

        foreach ($pastGames as $gameId => $pastGame) {
            if ($gameId === $pastTestGameNotActive->getId()) {
                $foundFutureGame = true;
            }
            if ($gameId === $futureTestGameSecond->getId()) {
                $foundFutureGameSecond = true;
            }
            if ($gameId === $pastTestGame->getId()) {
                $foundPastGame = true;
                self::assertSame(4, $pastGame->getFirstTeamUserResult());
                self::assertSame(5, $pastGame->getSecondTeamUserResult());
                self::assertSame(10, $pastGame->getScore());
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

    public function testActiveGameWithUserBetting()
    {
        $mockGameRatingFacade = $this->createMock(PointsInterface::class);

        $mockGameRatingFacade->method('get')
            ->willReturn(1);

        $userPastGames = new UserPastGames(
            $this->entityManager,
            $mockGameRatingFacade
        );

        $pastTestGameNotActive = $this->createTestPastGamesNotActive();
        $futureTestGameSecond = $this->createTestFutureGamesSecond();
        $pastTestGame = $this->createTestPastGames();
        $pastTestGameSecond = $this->createTestPastGamesSecond();

        $pastGames = $userPastGames->getActiveGames($this->getUser());
        $foundFutureGame = false;
        $foundFutureGameSecond = false;
        $foundPastGame = false;
        $foundPastGameSecond = false;

        foreach ($pastGames as $gameId => $pastGame) {
            if ($gameId === $pastTestGameNotActive->getId()) {
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
}