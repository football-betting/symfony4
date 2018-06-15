<?php declare(strict_types=1);


namespace App\GameBetting\Business\GamePoints\Score;


use App\GameBetting\Business\GamePoints\Config;
use App\GameBetting\Persistence\DataProvider\Result;

class NoWin implements ScoreInterface
{
    /**
     * @param Result $result
     * @return bool
     */
    public function check(Result $result): bool
    {
        return true;
    }

    /**
     * @return int
     */
    public function getScore(): int
    {
        return Config::NO_WIN_TEAM;
    }


}