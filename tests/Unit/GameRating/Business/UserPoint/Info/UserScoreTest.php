<?php


namespace App\Tests\Unit\GameRating\Business\UserPoint\Info;


use App\GameRating\Business\UserPoint\Info\UserScore;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Security\Core\User\UserInterface;

class UserScoreTest extends TestCase
{
    public function testUserScoreWithScore()
    {
        $userScore = new UserScore(
            $this->createMock(UserInterface::class)
        );
        $userScore->addScore(3);
        $userScore->addScore(3);
        $userScore->addScore(3);
        $userScore->addScore(3);

        $userScore->addScore(2);
        $userScore->addScore(2);

        $userScore->addScore(1);

        $userScore->addScore(0);

        $this->assertSame(17, $userScore->getScoreSumme());
        $this->assertSame(4, $userScore->getCountWinExact());
        $this->assertSame(2, $userScore->getCountWinScoreDiff());
        $this->assertSame(1, $userScore->getCountWinTeam());
        $this->assertSame(1, $userScore->getCountNoWinTeam());
    }

    public function testUserScoreWithNoScore()
    {
        $userScore = new UserScore(
            $this->createMock(UserInterface::class)
        );

        $this->assertSame(0, $userScore->getScoreSumme());
        $this->assertSame(0, $userScore->getCountWinExact());
        $this->assertSame(0, $userScore->getCountWinScoreDiff());
        $this->assertSame(0, $userScore->getCountWinTeam());
        $this->assertSame(0, $userScore->getCountNoWinTeam());
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testUserScoreException()
    {
        $userScore = new UserScore(
            $this->createMock(UserInterface::class)
        );
        $userScore->addScore(9999);
    }
}