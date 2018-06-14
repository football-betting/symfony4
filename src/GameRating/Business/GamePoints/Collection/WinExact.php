<?php declare(strict_types=1);

namespace App\GameRating\Business\GamePoints\Collection;

use App\GameRating\Business\GamePoints\Config;
use App\GameRating\Persistence\DataProvider\Result;

class WinExact implements CollectionInterface
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