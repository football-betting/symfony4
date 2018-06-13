<?php


namespace App\Tests\Api\GameApi\Business\ApiFootballData\Import;

use App\GameApi\Business\ApiFootballData\Client;
use App\GameApi\Business\ApiFootballData\Import\Team;
use App\GameApi\Business\ApiFootballData\Import\Game;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ImportTest extends KernelTestCase
{
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

        $this->entityManager->close();
        $this->entityManager = null;
    }

    public function testTeamImport()
    {
        $team = new Team(
            new Client(),
            $this->entityManager
        );
        $team->import();

        $teamRepo = $this->entityManager->getRepository(\App\GameCore\Persistence\Entity\Team::class);

        $polandTeamEntity = $teamRepo->findOneBy([
            'name' => 'Poland'
        ]);

        $this->assertInstanceOf(\App\GameCore\Persistence\Entity\Team::class, $polandTeamEntity);
        $this->assertSame('Poland', $polandTeamEntity->getName());

        $polandTeamEntity = $teamRepo->findOneBy([
            'name' => 'Germany'
        ]);

        $this->assertInstanceOf(\App\GameCore\Persistence\Entity\Team::class, $polandTeamEntity);
        $this->assertSame('Germany', $polandTeamEntity->getName());
    }


    public function testGameImport()
    {
        $game = new Game(
            new Client(),
            $this->entityManager
        );
        $game->import();

        $gameRepo = $this->entityManager->getRepository(\App\GameCore\Persistence\Entity\Game::class);

        $polandGamesHome = $gameRepo->findBy([
            'teamFirst' => 31
        ]);

        $this->assertCount(2, $polandGamesHome);

        $firstHomePolandGames = $polandGamesHome[0];
        $this->assertSame('2018-06-19 17:00:00', $firstHomePolandGames->getDate()->format('Y-m-d H:i:s'));
        $this->assertSame('Senegal', $firstHomePolandGames->getTeamSecond()->getName());
    }
}