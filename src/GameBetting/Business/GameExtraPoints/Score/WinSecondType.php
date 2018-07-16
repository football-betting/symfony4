<?php declare(strict_types=1);

namespace App\GameBetting\Business\GameExtraPoints\Score;


use App\GameBetting\Business\GameExtraPoints\Config;
use App\GameBetting\Persistence\DataProvider\ExtraResult;

class WinSecondType implements ScoreInterface
{
    /**
     * @return int
     */
    public function getScore() : int
    {
        return Config::WIN_SECOND_TYPE;
    }

    /**
     * @param ExtraResult $result
     * @return bool
     */
    public function check(ExtraResult $result): bool
    {
        return $result->getType() === 2 && $result->getCountryId() === Config::WIN_COUNTRY_ID;
    }
}