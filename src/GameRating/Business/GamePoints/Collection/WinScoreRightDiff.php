<?php declare(strict_types=1);

namespace App\GameRating\Business\GamePoints\Collection;

use App\GameRating\Business\GamePoints\Config;
use App\GameRating\Persistence\DataProvider\Result;

class WinScoreRightDiff implements CollectionInterface
{
    /**
     * @param Result $result
     * @return bool
     */
    public function check(Result $result): bool
    {
        $check = false;
        if ($result->getFirstTeamUserResult() !== null && $result->getSecondTeamUserResult() !== null) {
            $diffUserResult = $result->getFirstTeamUserResult() - $result->getSecondTeamUserResult();
            $diffGameResult = $result->getFirstTeamResult() - $result->getSecondTeamResult();
            $check = ($diffGameResult === $diffUserResult);
        }

        return $check;
    }

    public function getScore(): int
    {
        return Config::WIN_SCORE_DIFF;
    }


}