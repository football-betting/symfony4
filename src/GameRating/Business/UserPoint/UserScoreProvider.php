<?php


namespace App\GameRating\Business\UserPoint;

use App\GameBetting\Business\Games\UserPastGamesInterface;
use App\GameRating\Business\UserPoint\Info\UserScore;
use App\User\Persistence\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class UserScoreProvider implements UserScoreProviderInterface
{
    /**
     * @var UserPastGamesInterface
     */
    private $userPastGamesInterface;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @param EntityManagerInterface $entityManager
     * @param UserPastGamesInterface $userPastGamesInterface
     */
    public function __construct(EntityManagerInterface $entityManager, UserPastGamesInterface $userPastGamesInterface)
    {
        $this->entityManager = $entityManager;
        $this->userPastGamesInterface = $userPastGamesInterface;
    }

    /**
     * @return UserScore[]
     */
    public function get() : array
    {
        $users = $this->entityManager->getRepository(User::class)->findAll();
        $usersScores = [];
        foreach ($users as $user) {
            $userScore = new UserScore($user);
            $userPastGames = $this->userPastGamesInterface->get($user);
            foreach ($userPastGames as $userPastGame) {
                $userScore->addScore($userPastGame->getScore());
            }
            $usersScores[] = $userScore;
        }

        return $usersScores;
    }


}