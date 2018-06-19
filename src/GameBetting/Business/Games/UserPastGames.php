<?php

namespace App\GameBetting\Business\Games;

use App\GameBetting\Business\GamePoints\PointsInterface;
use App\GameBetting\Persistence\DataProvider\Result;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use App\GameBetting\Persistence\Entity\UserBetting as UserBettingEntity;
use App\GameCore\Persistence\Entity\Game;
use App\GameBetting\Persistence\DataProvider\GamePastBetting;

class UserPastGames implements UserPastGamesInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var PointsInterface
     */
    private $points;

    /**
     * @param EntityManagerInterface $entityManager
     * @param PointsInterface $points
     */
    public function __construct(EntityManagerInterface $entityManager, PointsInterface $points)
    {
        $this->entityManager = $entityManager;
        $this->points = $points;
    }

    /**
     * @param UserInterface $user
     * @return GamePastBetting[]
     */
    public function get(UserInterface $user): array
    {
        /** @var Game[] $pastGames */
        $pastGames = $this->entityManager
            ->getRepository(Game::class)
            ->findPastGames();

        return $this->getGamePastBetting($user, $pastGames);
    }

    /**
     * @param UserInterface $user
     * @return array
     * @throws \Exception
     */
    public function getActiveGames(UserInterface $user) : array
    {
        /** @var Game[] $pastGames */
        $activeGamesGames = $this->entityManager
            ->getRepository(Game::class)
            ->findActiveGames();

        return $this->getGamePastBetting($user, $activeGamesGames);
    }

    /**
     * @param UserInterface $user
     * @param Game[] $games
     * @return array
     */
    private function getGamePastBetting(UserInterface $user, array $games) : array
    {
        $pastGamesForm = [];
        $gameId2UserBets = $this->getGameIdForUserBets($user, $games);

        foreach ($games as $pastGame) {

            $pastGamesForm[$pastGame->getId()] = $this->getGamePastBettingInfo(
                $gameId2UserBets,
                $pastGame
            );
        }

        return $pastGamesForm;
    }

    /**
     * @param array $gameId2UserBets
     * @param Game $pastGame
     * @return GamePastBetting
     */
    private function getGamePastBettingInfo(array $gameId2UserBets, Game $pastGame): GamePastBetting
    {
        $firstTeamUserResult = null;
        $secondTeamUserResult = null;
        if (isset($gameId2UserBets[$pastGame->getId()])) {
            $firstTeamUserResult = $gameId2UserBets[$pastGame->getId()]->getFirstTeamResult();
            $secondTeamUserResult = $gameId2UserBets[$pastGame->getId()]->getSecondTeamResult();
        }

        $gameResult = new Result(
            (int)$pastGame->getFirstTeamResult(),
            (int)$pastGame->getSecondTeamResult(),
            $firstTeamUserResult,
            $secondTeamUserResult
        );

        return new GamePastBetting(
            $pastGame->getTeamFirst()->getName(),
            $pastGame->getTeamSecond()->getName(),
            $pastGame->getDate(),
            $gameResult->getFirstTeamResult(),
            $gameResult->getSecondTeamResult(),
            $gameResult->getFirstTeamUserResult(),
            $gameResult->getSecondTeamUserResult(),
            $this->points->get($gameResult)
        );
    }

    /**
     * @param UserInterface $user
     * @param Game[] $pastGames
     * @return UserBettingEntity[]
     */
    private function getGameIdForUserBets(UserInterface $user, array $pastGames): array
    {
        /** @var UserBettingEntity[] $userBets */
        $userBets = $this->entityManager
            ->getRepository(UserBettingEntity::class)
            ->findUserBettingByUserId($user, $pastGames);

        /** @var UserBettingEntity[] $gameId2UserBets */
        $gameId2UserBets = [];
        foreach ($userBets as $userBet) {
            $gameId2UserBets[$userBet->getGame()->getId()] = $userBet;
        }
        return $gameId2UserBets;
    }
}