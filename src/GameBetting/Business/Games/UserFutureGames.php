<?php

namespace App\GameBetting\Business\Games;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use App\GameBetting\Persistence\Entity\UserBetting as UserBettingEntity;
use App\GameCore\Persistence\Entity\Game;
use App\GameBetting\Persistence\DataProvider\UserBetting as UserBettingDataProvider;


class UserFutureGames implements UserFutureGamesInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function get(UserInterface $user): array
    {
        $futureGames = $this->entityManager
            ->getRepository(Game::class)
            ->findFutureGames();

        $gameId2UserBets = $this->getGameId2UserBets($user, $futureGames);
        $gamesInfo = [];
        /** @var Game $game */
        foreach ($futureGames as $game) {
            $bet = new UserBettingDataProvider();
            if (isset($gameId2UserBets[$game->getId()])) {
                $bet->setSecondTeamResult(
                    $gameId2UserBets[$game->getId()]->getSecondTeamResult()
                );
                $bet->setFirstTeamResult(
                    $gameId2UserBets[$game->getId()]->getFirstTeamResult()
                );
            }

            $gamesInfo[$game->getId()] = [
                'game' => $game,
                'bet' => $bet
            ];
        }

        return $gamesInfo;
    }

    /**
     * @param UserInterface $user
     * @param $futureGames
     * @return UserBettingEntity[]
     */
    private function getGameId2UserBets(UserInterface $user, array $futureGames): array
    {
        $userBets = $this->entityManager
            ->getRepository(UserBettingEntity::class)
            ->findUserBettingByUserId($user, $futureGames);

        /** @var UserBettingEntity[] $gameId2UserBets */
        $gameId2UserBets = [];
        /** @var UserBettingEntity $userBet */
        foreach ($userBets as $userBet) {
            $gameId2UserBets[$userBet->getGame()->getId()] = $userBet;
        }
        return $gameId2UserBets;
    }
}