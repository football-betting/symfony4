<?php


namespace App\GameBetting\Persistence\DataProvider;


class GamePastBetting
{
    /**
     * @var int
     */
    private $gameId;

    /**
     * @var string
     */
    private $firstTeamName;

    /**
     * @var string
     */
    private $secondTeamName;

    /**
     * @var \DateTimeInterface
     */
    private $gameDate;

    /**
     * @var int
     */
    private $firstTeamResult;

    /**
     * @var int
     */
    private $secondTeamResult;

    /**
     * @var int
     */
    private $firstTeamUserResult;

    /**
     * @var int
     */
    private $secondTeamUserResult;

    /**
     * @var int
     */
    private $score;

    /**
     * @param int $gameId
     * @param string $firstTeamName
     * @param string $secondTeamName
     * @param \DateTimeInterface $gameDate
     * @param int|null $firstTeamResult
     * @param int|null $secondTeamResult
     * @param int|null $firstTeamUserResult
     * @param int|null $secondTeamUserResult
     * @param int $score
     */
    public function __construct(
        int $gameId,
        string $firstTeamName,
        string $secondTeamName,
        \DateTimeInterface $gameDate,
        ?int $firstTeamResult,
        ?int $secondTeamResult,
        ?int $firstTeamUserResult,
        ?int $secondTeamUserResult,
        int $score
    )
    {
        $this->gameId = $gameId;
        $this->firstTeamName = $firstTeamName;
        $this->secondTeamName = $secondTeamName;
        $this->gameDate = $gameDate;
        $this->firstTeamResult = $firstTeamResult;
        $this->secondTeamResult = $secondTeamResult;
        $this->firstTeamUserResult = $firstTeamUserResult;
        $this->secondTeamUserResult = $secondTeamUserResult;
        $this->score = $score;
    }

    /**
     * @return int
     */
    public function getGameId(): int
    {
        return $this->gameId;
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
     * @return \DateTimeInterface
     */
    public function getGameDate(): \DateTimeInterface
    {
        return $this->gameDate;
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
     * @return int
     */
    public function getFirstTeamUserResult(): ?int
    {
        return $this->firstTeamUserResult;
    }

    /**
     * @return int
     */
    public function getSecondTeamUserResult(): ?int
    {
        return $this->secondTeamUserResult;
    }

    /**
     * @return int
     */
    public function getScore(): int
    {
        return $this->score;
    }
}