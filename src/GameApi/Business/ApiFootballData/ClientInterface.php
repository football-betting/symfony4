<?php

namespace App\GameApi\Business\ApiFootballData;

/**
 * @package App\GameApi\Business\ApiFootballData
 */
interface ClientInterface
{

    /**
     * @return array
     */
    public function getTeams(): array;

    /**
     * @return array
     */
    public function getGames(): array;
}