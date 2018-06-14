<?php


namespace App\GameRating\Persistence\DataProvider;


class Result
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
     * @var null|int
     */
    private $firstTeamUserResult;

    /**
     * @var null|int
     */
    private $secondTeamUserResult;

    /**
     * @param int $firstTeamResult
     * @param int $secondTeamResult
     * @param int|null $firstTeamUserResult
     * @param int|null $secondTeamUserResult
     */
    public function __construct(int $firstTeamResult, int $secondTeamResult, ?int $firstTeamUserResult, ?int $secondTeamUserResult)
    {
        $this->firstTeamResult = $firstTeamResult;
        $this->secondTeamResult = $secondTeamResult;
        $this->firstTeamUserResult = $firstTeamUserResult;
        $this->secondTeamUserResult = $secondTeamUserResult;
    }

    /**
     * @return int
     */
    public function getFirstTeamResult(): int
    {
        return $this->firstTeamResult;
    }

    /**
     * @return int
     */
    public function getSecondTeamResult(): int
    {
        return $this->secondTeamResult;
    }

    /**
     * @return int|null
     */
    public function getFirstTeamUserResult(): ?int
    {
        return $this->firstTeamUserResult;
    }

    /**
     * @return int|null
     */
    public function getSecondTeamUserResult(): ?int
    {
        return $this->secondTeamUserResult;
    }




}