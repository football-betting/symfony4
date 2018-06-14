<?php declare(strict_types=1);

namespace App\GameRating\Business\GamePoints\Collection;

use App\GameRating\Business\GamePoints\Config;
use App\GameRating\Persistence\DataProvider\Result;

class WinTeam implements CollectionInterface
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