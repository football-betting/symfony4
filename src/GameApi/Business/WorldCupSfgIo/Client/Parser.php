<?php declare(strict_types=1);


namespace App\GameApi\Business\WorldCupSfgIo\Client;


use App\GameApi\Persistence\DataProvider\GameResult;

class Parser implements ParserInterface
{
    /**
     * @param array $matchInfos
     * @return GameResult[]
     */
    public function get(array $matchInfos): array
    {
        $resultGames = [];
        foreach ($matchInfos as $matchInfo) {
            $homeTeam = $matchInfo['home_team'];
            $awayTeam = $matchInfo['away_team'];

            $resultGames[] = new GameResult(
                $homeTeam['country'],
                $awayTeam['country'],
                $this->getGoals($homeTeam),
                $this->getGoals($awayTeam)
            );
        }
        return $resultGames;
    }

    /**
     * @param array $team
     * @return int
     */
    private function getGoals(array $team): int
    {
        $goals = (int)$team['goals'];
        if (isset($team['penalties'])) {
            $goals += (int)$team['penalties'];
        }
        return $goals;
    }
}