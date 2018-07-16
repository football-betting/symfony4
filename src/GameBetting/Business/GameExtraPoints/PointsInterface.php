<?php

namespace App\GameBetting\Business\GameExtraPoints;

use App\GameBetting\Persistence\DataProvider\ExtraResult;

interface PointsInterface
{
    /**
     * @param ExtraResult $extraResult
     * @return int
     */
    public function get(ExtraResult $extraResult): int;
}