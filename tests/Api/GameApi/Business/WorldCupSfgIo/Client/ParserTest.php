<?php

namespace Api\Tests\GameApi\Business\WorldCupSfgIo\Client;

use App\GameApi\Business\WorldCupSfgIo\Client\Parser;
use PHPUnit\Framework\TestCase;

class ParserTest extends TestCase
{
    public function test()
    {
        $jsonInfo = json_decode(
            file_get_contents( __DIR__ . '/../../../../../Integration/Helper/json/current_game.json'),
            true
        );
        $paser = new Parser();
        $resultGames = $paser->get($jsonInfo);

        $this->assertCount(2, $resultGames);

        $this->assertSame($resultGames[0]->getFirstTeamName(), 'Spain');
        $this->assertSame($resultGames[0]->getSecondTeamName(), 'Morocco');

        $this->assertSame($resultGames[0]->getFirstTeamResult(), 2);
        $this->assertSame($resultGames[0]->getSecondTeamResult(), 2);

        $this->assertSame($resultGames[1]->getFirstTeamName(), 'Iran');
        $this->assertSame($resultGames[1]->getSecondTeamName(), 'Portugal');

        $this->assertSame($resultGames[1]->getFirstTeamResult(), 0);
        $this->assertSame($resultGames[1]->getSecondTeamResult(), 1);
    }
}