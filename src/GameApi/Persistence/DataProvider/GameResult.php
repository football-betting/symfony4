<?php


namespace App\GameApi\Persistence\DataProvider;

class GameResult
{
    /**
     * @var string
     */
    private $firstTeamName;

    /**
     * @var string
     */
    private $secondTeamName;

    /**
     * @var int
     */
    private $firstTeamResult;

    /**
     * @var int
     */
    private $secondTeamResult;

    /**
     * @param string $firstTeamName
     * @param string $secondTeamName
     * @param int $firstTeamResult
     * @param int $secondTeamResult
     */
    public function __construct(string $firstTeamName, string $secondTeamName, int $firstTeamResult, int $secondTeamResult)
    {
        $this->firstTeamName = $firstTeamName;
        $this->secondTeamName = $secondTeamName;
        $this->firstTeamResult = $firstTeamResult;
        $this->secondTeamResult = $secondTeamResult;
    }

    /**
     * @return string
     */
    public function getFirstTeamName(): string
    {
        return $this->firstTeamName;
    }

    /**
     * @return string
     */
    public function getSecondTeamName(): string
    {
        return $this->secondTeamName;
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



}