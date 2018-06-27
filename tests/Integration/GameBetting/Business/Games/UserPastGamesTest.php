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

        foreach ($pastGames as $pastGame) {
            if ($pastGame->getGameId() === $futureTestGame->getId()) {
                $foundFutureGame = true;
            }
            if ($pastGame->getGameId() === $futureTestGameSecond->getId()) {
                $foundFutureGameSecond = true;
            }
            if ($pastGame->getGameId() === $pastTestGame->getId()) {
                $foundPastGame = true;
            }
            if ($pastGame->getGameId() === $pastTestGameSecond->getId()) {
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

        foreach ($pastGames as $pastGame) {
            if ($pastGame->getGameId() === $futureTestGame->getId()) {
                $foundFutureGame = true;
            }
            if ($pastGame->getGameId() === $futureTestGameSecond->getId()) {
                $foundFutureGameSecond = true;
            }
            if ($pastGame->getGameId() === $pastTestGame->getId()) {
                $foundPastGame = true;
                self::assertSame(4, $pastGame->getFirstTeamUserResult());
                self::assertSame(5, $pastGame->getSecondTeamUserResult());
                self::assertSame(55, $pastGame->getScore());
            }
            if ($pastGame->getGameId() === $pastTestGameSecond->getId()) {
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

        foreach ($pastGames as $pastGame) {
            if ($pastGame->getGameId() === $pastTestGameNotActive->getId()) {
                $foundFutureGame = true;
            }
            if ($pastGame->getGameId() === $futureTestGameSecond->getId()) {
                $foundFutureGameSecond = true;
            }
            if ($pastGame->getGameId() === $pastTestGame->getId()) {
                $foundPastGame = true;
                self::assertSame(4, $pastGame->getFirstTeamUserResult());
                self::assertSame(5, $pastGame->getSecondTeamUserResult());
                self::assertSame(10, $pastGame->getScore());
            }
            if ($pastGame->getGameId() === $pastTestGameSecond->getId()) {
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

        foreach ($pastGames as $pastGame) {
            if ($pastGame->getGameId() === $pastTestGameNotActive->getId()) {
                $foundFutureGame = true;
            }
            if ($pastGame->getGameId() === $futureTestGameSecond->getId()) {
                $foundFutureGameSecond = true;
            }
            if ($pastGame->getGameId() === $pastTestGame->getId()) {
                $foundPastGame = true;
            }
            if ($pastGame->getGameId() === $pastTestGameSecond->getId()) {
                $foundPastGameSecond = true;
            }
        }

        self::assertFalse($foundFutureGame);
        self::assertFalse($foundFutureGameSecond);
        self::assertTrue($foundPastGame);
        self::assertTrue($foundPastGameSecond);
    }

    public function testGetOnePastGame()
    {
        $mockGameRatingFacade = $this->createMock(PointsInterface::class);

        $mockGameRatingFacade->method('get')
            ->willReturn(1);

        $userPastGames = new UserPastGames(
            $this->entityManager,
            $mockGameRatingFacade
        );

        $futureTestGame = $this->createTestFutureGames();
        $pastTestGame = $this->createTestPastGames();

        $pastGames = $userPastGames->getOnePastGame($this->getUser(), $pastTestGame->getId());

        self::assertCount(1, $pastGames);
        $foundFutureGame = false;
        $foundPastGame = false;

        foreach ($pastGames as $pastGame) {
            if ($pastGame->getGameId() === $futureTestGame->getId()) {
                $foundFutureGame = true;
            }
            if ($pastGame->getGameId() === $pastTestGame->getId()) {
                $foundPastGame = true;
                dump($pastTestGame);
            }
        }

        self::assertFalse($foundFutureGame);
        self::assertTrue($foundPastGame);
    }

    public function testGetOnePastGameNoGameFound()
    {
        $mockGameRatingFacade = $this->createMock(PointsInterface::class);

        $mockGameRatingFacade->method('get')
            ->willReturn(1);

        $userPastGames = new UserPastGames(
            $this->entityManager,
            $mockGameRatingFacade
        );

        $pastGames = $userPastGames->getOnePastGame($this->getUser(), 99999999);

        self::assertCount(0, $pastGames);
        self::assertEmpty($pastGames);
    }

}