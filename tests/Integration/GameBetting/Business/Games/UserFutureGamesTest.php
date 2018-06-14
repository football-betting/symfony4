<?php


namespace App\Tests\Integration\GameBetting\Business\Games;

use App\GameBetting\Business\Games\UserFutureGames;
use App\GameCore\Persistence\Entity\Game;
use App\Tests\Integration\Helper\Games;
use App\Tests\Integration\Helper\User;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserFutureGamesTest extends KernelTestCase
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


    public function testFutureGame()
    {
        $userFutureGames = new UserFutureGames(
            $this->entityManager
        );

        $futureTestGame = $this->createTestFutureGames();
        $pastTestGame = $this->createTestPastGames();

        $futureGames = $userFutureGames->get($this->getUser());
        $foundFutureGame = false;
        $foundPastGame = false;

        foreach ($futureGames as $futureGame) {
            /** @var Game $game */
            $game = $futureGame['game'];
            if ($game->getId() === $futureTestGame->getId()) {
                $foundFutureGame = true;
            }
            if ($game->getId() === $pastTestGame->getId()) {
                $foundPastGame = true;
            }
        }

        self::assertTrue($foundFutureGame);
        self::assertFalse($foundPastGame);

    }
}