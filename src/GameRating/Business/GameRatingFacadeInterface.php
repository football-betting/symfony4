<?php

namespace App\GameRating\Business;

use App\GameRating\Persistence\DataProvider\Result;

interface GameRatingFacadeInterface
{
    /**
     * @param Result $result
     * @return int
     */
    public function getPoints(Result $result);
}