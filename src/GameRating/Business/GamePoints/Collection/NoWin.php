<?php declare(strict_types=1);


namespace App\GameRating\Business\GamePoints\Collection;


use App\GameRating\Business\GamePoints\Config;
use App\GameRating\Persistence\DataProvider\Result;

class NoWin implements CollectionInterface
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