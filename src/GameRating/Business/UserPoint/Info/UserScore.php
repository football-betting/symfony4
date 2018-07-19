<?php declare(strict_types=1);

namespace App\GameRating\Business\UserPoint\Info;

use App\GameBetting\Business\GamePoints\Config;
use Symfony\Component\Security\Core\User\UserInterface;

class UserScore
{
    /**
     * @var array
     */
    private $score = [];

    /**
     * @var int
     */
    private $extraScore = 0;

    /**
     * @var UserInterface $user
     */
    private $user;

    /**
     * @param UserInterface $user
     */
    public function __construct(UserInterface $user)
    {
        $this->user = $user;
    }

    /**
     * @return UserInterface
     */
    public function getUser(): UserInterface
    {
        return $this->user;
    }

    /**
     * @param int $scorePoint
     */
    public function addScore(int $scorePoint): void
    {
        $this->checkPoint($scorePoint);
        $this->score[] = $scorePoint;
    }

    /**
     * @param int $extraScore
     */
    public function setExtraScore(int $extraScore): void
    {
        $this->extraScore = $extraScore;
    }

    /**
     * @return int
     */
    public function getScoreSumme(): int
    {
        return array_sum($this->score) + $this->getExtraScore();
    }

    /**
     * @return int
     */
    public function getCountWinExact(): int
    {
        return \count(array_keys($this->score, Config::WIN_EXACT));
    }

    /**
     * @return int
     */
    public function getCountWinScoreDiff(): int
    {
        return \count(array_keys($this->score, Config::WIN_SCORE_DIFF));
    }

    /**
     * @return int
     */
    public function getCountWinTeam(): int
    {
        return \count(array_keys($this->score, Config::WIN_TEAM));
    }

    /**
     * @return int
     */
    public function getCountNoWinTeam(): int
    {
        return \count(array_keys($this->score, Config::NO_WIN_TEAM));
    }

    /**
     * @return int
     */
    public function getExtraScore(): int
    {
        return $this->extraScore;
    }

    /**
     * @param int $point
     */
    private function checkPoint(int $point)
    {
        $allowedPoints = [
            Config::WIN_EXACT => true,
            Config::WIN_SCORE_DIFF => true,
            Config::WIN_TEAM => true,
            Config::NO_WIN_TEAM => true,
        ];
        if (!isset($allowedPoints[$point])) {
            throw new \RuntimeException('Point: ' . $point . ' is not allowed');
        }
    }
}