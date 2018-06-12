<?php


namespace App\GameBetting\Persistence\DataProvider;


class GamePastBetting
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
     * GamePastBetting constructor.
     * @param string $firstTeamName
     * @param string $secondTeamName
     * @param \DateTimeInterface $gameDate
     * @param int $firstTeamResult
     * @param int $secondTeamResult
     * @param int|null $firstTeamUserResult
     * @param int|null $secondTeamUserResult
     */
    public function __construct(
        string $firstTeamName,
        string $secondTeamName,
        \DateTimeInterface $gameDate,
        ?int $firstTeamResult,
        ?int $secondTeamResult,
        ?int $firstTeamUserResult,
        ?int $secondTeamUserResult
    ) {
        $this->firstTeamName = $firstTeamName;
        $this->secondTeamName = $secondTeamName;
        $this->gameDate = $gameDate;
        $this->firstTeamResult = $firstTeamResult;
        $this->secondTeamResult = $secondTeamResult;
        $this->firstTeamUserResult = $firstTeamUserResult;
        $this->secondTeamUserResult = $secondTeamUserResult;
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



}