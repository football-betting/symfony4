<?php

namespace App\GameRating\Business\UserPoint;

use App\GameRating\Business\UserPoint\Info\UserScore;

interface UserScoreProviderInterface
{
    /**
     * @return UserScore[]
     */
    public function get(): array;
}