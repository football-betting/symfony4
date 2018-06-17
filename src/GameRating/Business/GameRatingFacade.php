<?php


namespace App\GameRating\Business;


use App\GameRating\Business\UserPoint\UserRatingInterface;
use App\GameRating\Business\UserPoint\UserScoreProviderInterface;
use App\GameRating\Persistence\DataProvider\Result;

class GameRatingFacade implements GameRatingFacadeInterface
{

    /**
     * @var UserRatingInterface
     */
    private $userRating;

    /**
     * @var UserScoreProviderInterface
     */
    private $userScoreProvider;

    /**
     * @param UserRatingInterface $userRating
     * @param UserScoreProviderInterface $userScoreProvider
     */
    public function __construct(
        UserRatingInterface $userRating,
        UserScoreProviderInterface $userScoreProvider
    )
    {
        $this->userRating = $userRating;
        $this->userScoreProvider = $userScoreProvider;
    }


    /**
     * @return \App\GameRating\Persistence\DataProvider\UserScoreWithPosition[]|array
     */
    public function getUserScoreWithPosition() : array
    {
        return $this->userRating->sortUserByScore(
            $this->userScoreProvider->get()
        );
    }
}