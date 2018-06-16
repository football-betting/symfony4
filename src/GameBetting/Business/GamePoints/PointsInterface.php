<?php

namespace App\GameBetting\Business\GamePoints;

use App\GameBetting\Persistence\DataProvider\Result;

interface PointsInterface
{
    /**
     * @param Result $result
     * @return int
     */
    public function get(Result $result): int;
}