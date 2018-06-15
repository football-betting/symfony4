<?php

namespace App\GameRating\Business\UserPoint;

use App\GameRating\Business\UserPoint\Info\UserScore;
use App\GameRating\Persistence\DataProvider\UserScoreWithPosition;

interface UserRatingInterface
{
    /**
     * @param UserScore[] $usersScores
     * @return UserScoreWithPosition[]
     */
    public function sortUserByScore(array $usersScores): array;
}