<?php declare(strict_types=1);

namespace App\GameRating\Business\GamePoints\Collection;

use App\GameRating\Persistence\DataProvider\Result;

interface CollectionInterface
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