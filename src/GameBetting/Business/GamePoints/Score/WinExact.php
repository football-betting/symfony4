<?php declare(strict_types=1);

namespace App\GameBetting\Business\GamePoints\Score;

use App\GameBetting\Business\GamePoints\Config;
use App\GameBetting\Persistence\DataProvider\Result;

class WinExact implements ScoreInterface
{
    /**
     * @return int
     */
    public function getScore() : int
    {
        return Config::WIN_EXACT;
    }

    /**
     * @param Result $result
     * @return bool
     */
    public function check(Result $result): bool
    {
        return $result->getFirstTeamUserResult() === $result->getFirstTeamResult()
            && $result->getSecondTeamUserResult() === $result->getSecondTeamResult();
    }
}