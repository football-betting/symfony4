<?php

namespace App\GameRating\Business;

use App\GameRating\Persistence\DataProvider\Result;

interface GameRatingFacadeInterface
{
    /**
     * @return \App\GameRating\Persistence\DataProvider\UserScoreWithPosition[]|array
     */
    public function getUserScoreWithPosition(): array;
}