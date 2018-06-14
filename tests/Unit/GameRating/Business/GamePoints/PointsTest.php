<?php declare(strict_types=1);


namespace App\Tests\Unit\GameRating\Business\GamePoints;


use App\GameRating\Business\GamePoints\Collection\NoWin;
use App\GameRating\Business\GamePoints\Collection\WinExact;
use App\GameRating\Business\GamePoints\Collection\WinScoreRightDiff;
use App\GameRating\Business\GamePoints\Collection\WinTeam;
use App\GameRating\Business\GamePoints\Points;
use App\GameRating\Persistence\DataProvider\Result;
use App\GameRating\Business\GamePoints\Config;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\Tests\Fixtures\StdClassDecorator;

class PointsTest extends TestCase
{
    /**
     * 0 - firstTeamResult
     * 1 - secondTeamResult
     * 2 - firstTeamUserResult
     * 3 - secondTeamUserResult
     * 4 - expectedScore
     * @return array
     */
    public function data()
    {
        return [
            // NO_WIN_TEAM
            [2, 1, 0, 1, Config::NO_WIN_TEAM],
            [1, 3, 3, 2, Config::NO_WIN_TEAM],
            [0, 0, 2, 0, Config::NO_WIN_TEAM],
            [0, 1, 0, 0, Config::NO_WIN_TEAM],

            // WIN_EXACT
            [1, 2, 1, 2, Config::WIN_EXACT],
            [2, 1, 2, 1, Config::WIN_EXACT],
            [2, 0, 2, 0, Config::WIN_EXACT],
            [0, 2, 0, 2, Config::WIN_EXACT],
            [2, 2, 2, 2, Config::WIN_EXACT],

            // WIN_SCORE_DIFF
            [1, 3, 2, 4, Config::WIN_SCORE_DIFF],
            [4, 2, 3, 1, Config::WIN_SCORE_DIFF],
            [1, 0, 2, 1, Config::WIN_SCORE_DIFF],
            [1, 2, 0, 1, Config::WIN_SCORE_DIFF],
            [3, 3, 0, 0, Config::WIN_SCORE_DIFF],
            [3, 3, 4, 4, Config::WIN_SCORE_DIFF],

            // WIN_TEAM
            [1, 3, 1, 2, Config::WIN_TEAM],
            [2, 1, 3, 1, Config::WIN_TEAM],
            [1, 0, 2, 0, Config::WIN_TEAM],
            [0, 5, 0, 2, Config::WIN_TEAM],
            [2, 3, 2, 5, Config::WIN_TEAM],

            // NO_WIN_TEAM
            [2, 1, 0, 1, Config::NO_WIN_TEAM],
            [1, 3, 3, 2, Config::NO_WIN_TEAM],
            [0, 0, 2, 0, Config::NO_WIN_TEAM],
            [0, 1, 0, 0, Config::NO_WIN_TEAM],
            [0, 1, null, null, Config::NO_WIN_TEAM],
            [0, 0, null, null, Config::NO_WIN_TEAM],
            [1, 0, null, null, Config::NO_WIN_TEAM],


        ];
    }

    /**
     * @param $firstTeamResult
     * @param $secondTeamResult
     * @param $firstTeamUserResult
     * @param $secondTeamUserResult
     * @param $expectedScore
     * @dataProvider data
     */
    public function testPoint($firstTeamResult, $secondTeamResult, $firstTeamUserResult, $secondTeamUserResult, $expectedScore)
    {
        $points = new Points(
            new WinExact(),
            new NoWin(),
            new WinTeam(),
            new WinScoreRightDiff()
        );

        $result = new Result(
            $firstTeamResult,
            $secondTeamResult,
            $firstTeamUserResult,
            $secondTeamUserResult
        );

        $score = $points->get($result);

        $this->assertSame($expectedScore, $score);
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testException()
    {
        $points = new Points(
            new \stdClass,
            new \stdClass
        );

        $result = new Result(1, 1, 1, 1);
        $points->get($result);
    }
}