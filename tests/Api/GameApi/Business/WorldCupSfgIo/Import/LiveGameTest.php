<?php declare(strict_types=1);


namespace App\Tests\Api\GameApi\Business\WorldCupSfgIo\Import;

use App\GameApi\Business\WorldCupSfgIo\Client\ClientInterface;
use App\GameApi\Business\WorldCupSfgIo\Client\Parser;
use App\GameApi\Business\WorldCupSfgIo\Import\LiveGame;
use App\GameCore\Persistence\Entity\Game;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class LiveGameTest extends KernelTestCase
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

    public function testChangeMatch()
    {
        $this->changeGameEntityForTest();
        $mockClient = $this->getClientMockForFirstResult();

        $liveGame = new LiveGame(
            $this->entityManager,
            $mockClient
        );

        $liveGame->updateLiveGames();
        $spainVsMaroccoGamesHome = $this->getGameEntity();

        $this->assertSame(2, $spainVsMaroccoGamesHome->getFirstTeamResult());
        $this->assertSame(2, $spainVsMaroccoGamesHome->getSecondTeamResult());
    }

    public function testChangeMatchSecondResult()
    {
        $this->changeGameEntityForTest();
        $mockClient = $this->getClientMockForSecondResult();

        $liveGame = new LiveGame(
            $this->entityManager,
            $mockClient
        );

        $liveGame->updateLiveGames();
        $spainVsMaroccoGamesHome = $this->getGameEntity();

        $this->assertSame(1, $spainVsMaroccoGamesHome->getFirstTeamResult());
        $this->assertSame(2, $spainVsMaroccoGamesHome->getSecondTeamResult());
    }


    private function changeGameEntityForTest(): void
    {
        $spainVsMaroccoGamesHome = $this->getGameEntity();

        $this->assertInstanceOf(Game::class, $spainVsMaroccoGamesHome);
        $spainVsMaroccoGamesHome->setFirstTeamResult(5);
        $spainVsMaroccoGamesHome->setSecondTeamResult(5);

        $dateTime = new \DateTime('now', new \DateTimeZone('Europe/Berlin'));
        $dateTime->sub(new \DateInterval('PT1M'));

        $spainVsMaroccoGamesHome->setDate($dateTime);

        $this->entityManager->persist($spainVsMaroccoGamesHome);
        $this->entityManager->flush();
    }

    /**
     * @return ClientInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    private function getClientMockForFirstResult()
    {
        $jsonInfo = json_decode(
            file_get_contents(__DIR__ . '/../../../../../Integration/Helper/json/current_game.json'),
            true
        );
        $parser = new Parser();
        $resultGames = $parser->get($jsonInfo);
        $mockClient = $this->createMock(ClientInterface::class);
        $mockClient->method('getGames')
            ->willReturn($resultGames);
        return $mockClient;
    }

    /**
     * @return ClientInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    private function getClientMockForSecondResult()
    {
        $jsonInfo = json_decode(
            file_get_contents(__DIR__ . '/../../../../../Integration/Helper/json/current_game_v2.json'),
            true
        );
        $parser = new Parser();
        $resultGames = $parser->get($jsonInfo);
        $mockClient = $this->createMock(ClientInterface::class);
        $mockClient->method('getGames')
            ->willReturn($resultGames);
        return $mockClient;
    }

    /**
     * @return Game|null|object
     */
    private function getGameEntity()
    {
        $teamRepo = $this->entityManager->getRepository(\App\GameCore\Persistence\Entity\Team::class);
        $spainTeamEntity = $teamRepo->findOneBy([
            'name' => 'Spain'
        ]);
        $maroccoTeamEntity = $teamRepo->findOneBy([
            'name' => 'Morocco'
        ]);

        $gameRepo = $this->entityManager->getRepository(\App\GameCore\Persistence\Entity\Game::class);
        $spainVsMaroccoGamesHome = $gameRepo->findOneBy([
            'teamFirst' => $spainTeamEntity,
            'teamSecond' => $maroccoTeamEntity
        ]);
        return $spainVsMaroccoGamesHome;
    }
}