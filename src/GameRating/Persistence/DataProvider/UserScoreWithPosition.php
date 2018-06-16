<?php

namespace App\GameRating\Persistence\DataProvider;

use App\GameRating\Business\UserPoint\Info\UserScore;

class UserScoreWithPosition
{
    /**
     * @var int
     */
    private $position;

    /**
     * @var UserScore
     */
    private $userScore;

    /**
     * @param int $position
     * @param UserScore $userScore
     */
    public function __construct(int $position, UserScore $userScore)
    {
        $this->position = $position;
        $this->userScore = $userScore;
    }

    /**
     * @return int
     */
    public function getPosition(): int
    {
        return $this->position;
    }

    /**
     * @return UserScore
     */
    public function getUserScore(): UserScore
    {
        return $this->userScore;
    }
}