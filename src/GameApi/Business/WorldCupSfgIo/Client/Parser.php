<?php declare(strict_types=1);


namespace App\GameApi\Business\WorldCupSfgIo\Client;


use App\GameApi\Persistence\DataProvider\GameResult;

class Parser implements ParserInterface
{
    /**
     * @param array $matchInfos
     * @return GameResult[]
     */
    public function get(array $matchInfos) : array
    {
        $resultGames = [];
        foreach ($matchInfos as $matchInfo) {
           $homeTeam = $matchInfo['home_team'];
           $awayTeam = $matchInfo['away_team'];
           $resultGames[] = new GameResult(
               $homeTeam['country'],
               $awayTeam['country'],
               (int)$homeTeam['goals'],
               (int)$awayTeam['goals']
           );
        }
        return $resultGames;
    }
}