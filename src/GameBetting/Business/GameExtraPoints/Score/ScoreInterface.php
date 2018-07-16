<?php declare(strict_types=1);

namespace App\GameBetting\Business\GameExtraPoints\Score;

use App\GameBetting\Persistence\DataProvider\ExtraResult;

interface ScoreInterface
{
    /**
     * @return int
     */
    public function getScore(): int;

    /**
     * @param ExtraResult $result
     * @return bool
     */
    public function check(ExtraResult $result): bool;
}