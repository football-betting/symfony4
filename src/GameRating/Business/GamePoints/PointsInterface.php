<?php

namespace App\GameRating\Business\GamePoints;

use App\GameRating\Persistence\DataProvider\Result;

interface PointsInterface
{
    /**
     * @param Result $result
     * @return int
     */
    public function get(Result $result): int;
}