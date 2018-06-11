<?php

namespace App\GameCore\Persistence\Entity;

use App\GameCore\Persistence\Entity\Team;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\GameCore\Persistence\Repository\GameRepository")
 */
class Game
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\GameCore\Persistence\Entity\Team", inversedBy="installations")
     * @ORM\JoinColumn(name="team_first_id", referencedColumnName="id")
     */
    private $teamFirst;

    /**
     * @ORM\ManyToOne(targetEntity="App\GameCore\Persistence\Entity\Team", inversedBy="installations")
     * @ORM\JoinColumn(name="team_second_id", referencedColumnName="id")
     */
    private $teamSecond;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $firstTeamResult;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $secondTeamResult;

    /**
     * @var int
     * @ORM\Column(type="integer", nullable=true)
     */
    private $type;

    public function getId()
    {
        return $this->id;
    }

    public function getTeamFirst(): ?Team
    {
        return $this->teamFirst;
    }

    public function setTeamFirst(Team $teamFirst): self
    {
        $this->teamFirst = $teamFirst;

        return $this;
    }

    public function getTeamSecond(): ?Team
    {
        return $this->teamSecond;
    }

    public function setTeamSecond(Team $teamSecond): self
    {
        $this->teamSecond = $teamSecond;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getFirstTeamResult(): ?int
    {
        return $this->firstTeamResult;
    }

    public function setFirstTeamResult(int $firstTeamResult): self
    {
        $this->firstTeamResult = $firstTeamResult;

        return $this;
    }

    public function getSecondTeamResult(): ?int
    {
        return $this->secondTeamResult;
    }

    public function setSecondTeamResult(int $secondTeamResult): self
    {
        $this->secondTeamResult = $secondTeamResult;

        return $this;
    }

    /**
     * @return int
     */
    public function getType(): int
    {
        return $this->type;
    }

    /**
     * @param int $type
     */
    public function setType(int $type): void
    {
        $this->type = $type;
    }
}

