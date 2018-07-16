<?php


namespace App\GameRating\Business\UserPoint;

use App\GameBetting\Business\GameExtraPoints\PointsProviderInterface;
use App\GameBetting\Business\Games\UserPastGamesInterface;
use App\GameRating\Business\UserPoint\Info\UserScore;
use App\User\Persistence\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class UserScoreProvider implements UserScoreProviderInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var UserPastGamesInterface
     */
    private $userPastGamesInterface;

    /**
     * @var PointsProviderInterface
     */
    private $extraPointProvider;

    /**
     * @param EntityManagerInterface $entityManager
     * @param UserPastGamesInterface $userPastGamesInterface
     * @param PointsProviderInterface $extraPointProvider
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        UserPastGamesInterface $userPastGamesInterface,
        PointsProviderInterface $extraPointProvider
    )
    {
        $this->entityManager = $entityManager;
        $this->userPastGamesInterface = $userPastGamesInterface;
        $this->extraPointProvider = $extraPointProvider;
    }


    /**
     * @return UserScore[]
     */
    public function get(): array
    {
        $users = $this->entityManager->getRepository(User::class)->findAll();
        $usersScores = [];
        foreach ($users as $user) {
            $userScore = new UserScore($user);
            $userPastGames = $this->userPastGamesInterface->get($user);
            foreach ($userPastGames as $userPastGame) {
                $userScore->addScore($userPastGame->getScore());
            }
            $extraScore = $this->extraPointProvider->get($user);
            $userScore->setExtraScore($extraScore);
            $usersScores[] = $userScore;
        }

        return $usersScores;
    }


}