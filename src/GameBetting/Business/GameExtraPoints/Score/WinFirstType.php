<?php declare(strict_types=1);

namespace App\GameBetting\Business\GameExtraPoints\Score;

use App\GameBetting\Business\GameExtraPoints\Config;
use App\GameBetting\Persistence\DataProvider\ExtraResult;

class WinFirstType implements ScoreInterface
{
    /**
     * @return int
     */
    public function getScore() : int
    {
        return Config::WIN_FIRST_TYPE;
    }


    public function check(ExtraResult $result): bool
    {
        return $result->getType() === 1 && $result->getCountryId() === Config::WIN_COUNTRY_ID;
    }
}