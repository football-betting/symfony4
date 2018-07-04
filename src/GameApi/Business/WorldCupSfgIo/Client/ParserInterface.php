<?php

namespace App\GameApi\Business\WorldCupSfgIo\Client;

use App\GameApi\Persistence\DataProvider\GameResult;

interface ParserInterface
{
    /**
     * @param array $matchInfos
     * @return GameResult[]
     */
    public function get(array $matchInfos): array;
}