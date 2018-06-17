<?php declare(strict_types=1);

namespace App\GameBetting\Business\GamePoints\Score;

use App\GameBetting\Persistence\DataProvider\Result;

interface ScoreInterface
{
    /**
     * @param Result $result
     * @return bool
     */
    public function check(Result $result): bool;

    /**
     * @return int
     */
    public function getScore(): int;
}