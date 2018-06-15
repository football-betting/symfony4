<?php declare(strict_types=1);

namespace App\GameBetting\Business\GamePoints\Score;

use App\GameBetting\Business\GamePoints\Config;
use App\GameBetting\Persistence\DataProvider\Result;

class WinTeam implements ScoreInterface
{
    /**
     * @param Result $result
     * @return bool
     */
    public function check(Result $result): bool
    {
        $check = false;
        if ($result->getFirstTeamResult() !== $result->getSecondTeamResult()
            && $result->getFirstTeamUserResult() !== $result->getSecondTeamUserResult()
        ) {
            $hasWinFirstTeam = $result->getFirstTeamResult() > $result->getSecondTeamResult();
            $hasUserWinFirstTeam = $result->getFirstTeamUserResult() > $result->getSecondTeamUserResult();
            $check = $hasWinFirstTeam === $hasUserWinFirstTeam;
        }
        return $check;
    }

    public function getScore(): int
    {
        return Config::WIN_TEAM;
    }

}