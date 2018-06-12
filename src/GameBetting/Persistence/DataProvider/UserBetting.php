<?php


namespace App\GameBetting\Persistence\DataProvider;


class UserBetting
{

    /**
     * @var int
     */
    private $firstTeamResult;

    /**
     * @var int
     */
    private $secondTeamResult;

    /**
     * @return int
     */
    public function getFirstTeamResult(): ?int
    {
        return $this->firstTeamResult;
    }

    /**
     * @param int $firstTeamResult
     */
    public function setFirstTeamResult(int $firstTeamResult): void
    {
        $this->firstTeamResult = $firstTeamResult;
    }

    /**
     * @return int
     */
    public function getSecondTeamResult(): ?int
    {
        return $this->secondTeamResult;
    }

    /**
     * @param int $secondTeamResult
     */
    public function setSecondTeamResult(int $secondTeamResult): void
    {
        $this->secondTeamResult = $secondTeamResult;
    }


}