<?php

namespace App\GameApi\Business\WorldCupSfgIo\Client;

interface ClientInterface
{
    /**
     * @return \App\GameApi\Persistence\DataProvider\GameResult[]
     */
    public function getGames() : array;
}