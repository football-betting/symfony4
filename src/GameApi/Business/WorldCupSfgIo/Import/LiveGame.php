<?php declare(strict_types=1);


namespace App\GameApi\Business\WorldCupSfgIo\Import;


use App\GameApi\Business\WorldCupSfgIo\Client\ClientInterface;
use App\GameCore\Persistence\Entity\Game;
use Doctrine\ORM\EntityManagerInterface;

class LiveGame implements LiveGameInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var ClientInterface
     */
    private $client;

    /**
     * @param EntityManagerInterface $entityManager
     * @param ClientInterface $client
     */
    public function __construct(EntityManagerInterface $entityManager, ClientInterface $client)
    {
        $this->entityManager = $entityManager;
        $this->client = $client;
    }

    public function updateLiveGames() : void
    {
        $activeGamesGames = $this->entityManager
            ->getRepository(Game::class)
            ->findActiveGames();

        if (!empty($activeGamesGames)) {
            $changeEntity = false;
            $games = $this->client->getGames();
            foreach ($activeGamesGames as $activeGamesGame) {
                foreach ($games as $game) {
                    $findTeamFirst = $activeGamesGame->getTeamFirst()->getName() === $game->getFirstTeamName();
                    $findTeamSecond = $activeGamesGame->getTeamSecond()->getName() === $game->getSecondTeamName();
                    $checkTeamFirstResult = (int)$activeGamesGame->getFirstTeamResult() !== $game->getFirstTeamResult();
                    $checkTeamSecondResult = (int)$activeGamesGame->getSecondTeamResult() !== $game->getSecondTeamResult();
                    if ($findTeamFirst && $findTeamSecond && ($checkTeamFirstResult || $checkTeamSecondResult)) {
                        $changeEntity = true;
                        $activeGamesGame->setFirstTeamResult($game->getFirstTeamResult());
                        $activeGamesGame->setSecondTeamResult($game->getSecondTeamResult());
                        $this->entityManager->persist($activeGamesGame);
                    }
                }
            }

            if ($changeEntity === true) {
                $this->entityManager->flush($activeGamesGame);
            }
        }
    }


}