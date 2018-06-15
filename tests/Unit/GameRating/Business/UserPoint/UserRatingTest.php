<?php


namespace App\Tests\Unit\GameRating\Business\UserPoint;


use App\GameRating\Business\UserPoint\Info\UserScore;
use App\GameRating\Business\UserPoint\UserRating;
use App\User\Persistence\Entity\User;
use PHPUnit\Framework\TestCase;

class UserRatingTest extends TestCase
{
    public function testUserWithThreeSamePositionInMittle()
    {
        $userRating = new UserRating();
        $userScores = [];

        $user = new User();
        $user->setUsername('first');
        $userScore = new UserScore($user);
        $userScore->addScore(3);
        $userScore->addScore(3);
        $userScore->addScore(3);
        $userScores[] = $userScore;

        $user = new User();
        $user->setUsername('last');
        $userScore = new UserScore($user);
        $userScores[] = $userScore;

        $user = new User();
        $user->setUsername('second');
        $userScore = new UserScore($user);
        $userScore->addScore(2);
        $userScore->addScore(2);
        $userScore->addScore(2);
        $userScores[] = $userScore;

        $user = new User();
        $user->setUsername('oneBeforeLast');
        $userScore = new UserScore($user);
        $userScore->addScore(1);
        $userScores[] = $userScore;

        $user = new User();
        $user->setUsername('threeFirst');
        $userScore = new UserScore($user);
        $userScore->addScore(3);
        $userScores[] = $userScore;

        $user = new User();
        $user->setUsername('threeSecond');
        $userScore = new UserScore($user);
        $userScore->addScore(1);
        $userScore->addScore(2);
        $userScores[] = $userScore;

        $user = new User();
        $user->setUsername('threeThree');
        $userScore = new UserScore($user);
        $userScore->addScore(2);
        $userScore->addScore(1);
        $userScores[] = $userScore;

        $usersPositionAndScore = $userRating->sortUserByScore($userScores);

        $this->assertSame('first', $usersPositionAndScore[0]->getUserScore()->getUser()->getUsername());
        $this->assertSame(1, $usersPositionAndScore[0]->getPosition());

        $this->assertSame('second', $usersPositionAndScore[1]->getUserScore()->getUser()->getUsername());
        $this->assertSame(2, $usersPositionAndScore[1]->getPosition());

        $this->assertSame('threeFirst', $usersPositionAndScore[2]->getUserScore()->getUser()->getUsername());
        $this->assertSame(3, $usersPositionAndScore[2]->getPosition());

        $this->assertSame('threeSecond', $usersPositionAndScore[3]->getUserScore()->getUser()->getUsername());
        $this->assertSame(3, $usersPositionAndScore[3]->getPosition());

        $this->assertSame('threeThree', $usersPositionAndScore[4]->getUserScore()->getUser()->getUsername());
        $this->assertSame(3, $usersPositionAndScore[4]->getPosition());

        $this->assertSame('oneBeforeLast', $usersPositionAndScore[5]->getUserScore()->getUser()->getUsername());
        $this->assertSame(6, $usersPositionAndScore[5]->getPosition());

        $this->assertSame('last', $usersPositionAndScore[6]->getUserScore()->getUser()->getUsername());
        $this->assertSame(7, $usersPositionAndScore[6]->getPosition());
    }

    public function testUserWithFirstSamePosition()
    {
        $userRating = new UserRating();
        $userScores = [];

        $user = new User();
        $user->setUsername('first');
        $userScore = new UserScore($user);
        $userScore->addScore(3);
        $userScore->addScore(3);
        $userScore->addScore(3);
        $userScores[] = $userScore;

        $user = new User();
        $user->setUsername('last');
        $userScore = new UserScore($user);
        $userScores[] = $userScore;

        $user = new User();
        $user->setUsername('second');
        $userScore = new UserScore($user);
        $userScore->addScore(2);
        $userScore->addScore(2);
        $userScore->addScore(2);
        $userScores[] = $userScore;

        $user = new User();
        $user->setUsername('oneBeforeLast');
        $userScore = new UserScore($user);
        $userScore->addScore(1);
        $userScores[] = $userScore;

        $user = new User();
        $user->setUsername('three');
        $userScore = new UserScore($user);
        $userScore->addScore(3);
        $userScores[] = $userScore;

        $user = new User();
        $user->setUsername('firstSecond');
        $userScore = new UserScore($user);
        $userScore->addScore(1);
        $userScore->addScore(2);
        $userScore->addScore(3);
        $userScore->addScore(3);
        $userScores[] = $userScore;

        $usersPositionAndScore = $userRating->sortUserByScore($userScores);

        $this->assertSame('first', $usersPositionAndScore[0]->getUserScore()->getUser()->getUsername());
        $this->assertSame(1, $usersPositionAndScore[0]->getPosition());

        $this->assertSame('firstSecond', $usersPositionAndScore[1]->getUserScore()->getUser()->getUsername());
        $this->assertSame(1, $usersPositionAndScore[1]->getPosition());

        $this->assertSame('second', $usersPositionAndScore[2]->getUserScore()->getUser()->getUsername());
        $this->assertSame(3, $usersPositionAndScore[2]->getPosition());

        $this->assertSame('three', $usersPositionAndScore[3]->getUserScore()->getUser()->getUsername());
        $this->assertSame(4, $usersPositionAndScore[3]->getPosition());

        $this->assertSame('oneBeforeLast', $usersPositionAndScore[4]->getUserScore()->getUser()->getUsername());
        $this->assertSame(5, $usersPositionAndScore[4]->getPosition());

        $this->assertSame('last', $usersPositionAndScore[5]->getUserScore()->getUser()->getUsername());
        $this->assertSame(6, $usersPositionAndScore[5]->getPosition());
    }

    public function testUserWithFirstSameTwoPositionInLastTable()
    {
        $userRating = new UserRating();
        $userScores = [];

        $user = new User();
        $user->setUsername('first');
        $userScore = new UserScore($user);
        $userScore->addScore(3);
        $userScore->addScore(3);
        $userScore->addScore(3);
        $userScores[] = $userScore;

        $user = new User();
        $user->setUsername('last');
        $userScore = new UserScore($user);
        $userScores[] = $userScore;

        $user = new User();
        $user->setUsername('second');
        $userScore = new UserScore($user);
        $userScore->addScore(2);
        $userScore->addScore(2);
        $userScore->addScore(2);
        $userScores[] = $userScore;

        $user = new User();
        $user->setUsername('oneBeforeLast');
        $userScore = new UserScore($user);
        $userScore->addScore(1);
        $userScores[] = $userScore;

        $user = new User();
        $user->setUsername('three');
        $userScore = new UserScore($user);
        $userScore->addScore(3);
        $userScores[] = $userScore;

        $user = new User();
        $user->setUsername('lastSecond');
        $userScore = new UserScore($user);
        $userScore->addScore(0);
        $userScores[] = $userScore;

        $usersPositionAndScore = $userRating->sortUserByScore($userScores);

        $this->assertSame('first', $usersPositionAndScore[0]->getUserScore()->getUser()->getUsername());
        $this->assertSame(1, $usersPositionAndScore[0]->getPosition());

        $this->assertSame('second', $usersPositionAndScore[1]->getUserScore()->getUser()->getUsername());
        $this->assertSame(2, $usersPositionAndScore[1]->getPosition());

        $this->assertSame('three', $usersPositionAndScore[2]->getUserScore()->getUser()->getUsername());
        $this->assertSame(3, $usersPositionAndScore[2]->getPosition());

        $this->assertSame('oneBeforeLast', $usersPositionAndScore[3]->getUserScore()->getUser()->getUsername());
        $this->assertSame(4, $usersPositionAndScore[3]->getPosition());

        $this->assertSame('last', $usersPositionAndScore[4]->getUserScore()->getUser()->getUsername());
        $this->assertSame(5, $usersPositionAndScore[4]->getPosition());

        $this->assertSame('lastSecond', $usersPositionAndScore[5]->getUserScore()->getUser()->getUsername());
        $this->assertSame(5, $usersPositionAndScore[5]->getPosition());
    }

    public function testUserWithNoSamePoints()
    {
        $userRating = new UserRating();
        $userScores = [];

        $user = new User();
        $user->setUsername('first');
        $userScore = new UserScore($user);
        $userScore->addScore(3);
        $userScore->addScore(3);
        $userScore->addScore(3);
        $userScores[] = $userScore;

        $user = new User();
        $user->setUsername('last');
        $userScore = new UserScore($user);
        $userScores[] = $userScore;

        $user = new User();
        $user->setUsername('second');
        $userScore = new UserScore($user);
        $userScore->addScore(2);
        $userScore->addScore(2);
        $userScore->addScore(2);
        $userScores[] = $userScore;

        $user = new User();
        $user->setUsername('oneBeforeLast');
        $userScore = new UserScore($user);
        $userScore->addScore(1);
        $userScores[] = $userScore;

        $user = new User();
        $user->setUsername('three');
        $userScore = new UserScore($user);
        $userScore->addScore(3);
        $userScores[] = $userScore;

        $usersPositionAndScore = $userRating->sortUserByScore($userScores);

        $this->assertSame('first', $usersPositionAndScore[0]->getUserScore()->getUser()->getUsername());
        $this->assertSame(1, $usersPositionAndScore[0]->getPosition());

        $this->assertSame('second', $usersPositionAndScore[1]->getUserScore()->getUser()->getUsername());
        $this->assertSame(2, $usersPositionAndScore[1]->getPosition());

        $this->assertSame('three', $usersPositionAndScore[2]->getUserScore()->getUser()->getUsername());
        $this->assertSame(3, $usersPositionAndScore[2]->getPosition());

        $this->assertSame('oneBeforeLast', $usersPositionAndScore[3]->getUserScore()->getUser()->getUsername());
        $this->assertSame(4, $usersPositionAndScore[3]->getPosition());

        $this->assertSame('last', $usersPositionAndScore[4]->getUserScore()->getUser()->getUsername());
        $this->assertSame(5, $usersPositionAndScore[4]->getPosition());
    }

    public function testUserZeroPoints()
    {
        $userRating = new UserRating();
        $userScores = [];

        $user = new User();
        $user->setUsername('first');
        $userScore = new UserScore($user);
        $userScores[] = $userScore;

        $user = new User();
        $user->setUsername('second');
        $userScore = new UserScore($user);
        $userScores[] = $userScore;

        $user = new User();
        $user->setUsername('last');
        $userScore = new UserScore($user);
        $userScores[] = $userScore;

        $usersPositionAndScore = $userRating->sortUserByScore($userScores);

        $this->assertSame('first', $usersPositionAndScore[0]->getUserScore()->getUser()->getUsername());
        $this->assertSame(1, $usersPositionAndScore[0]->getPosition());

        $this->assertSame('second', $usersPositionAndScore[1]->getUserScore()->getUser()->getUsername());
        $this->assertSame(1, $usersPositionAndScore[1]->getPosition());

        $this->assertSame('last', $usersPositionAndScore[2]->getUserScore()->getUser()->getUsername());
        $this->assertSame(1, $usersPositionAndScore[2]->getPosition());
    }
}