<?php

namespace App\GameBetting\Persistence\Entity;

use App\GameCore\Persistence\Entity\Game;
use App\User\Persistence\Entity\User;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\GameBetting\Persistence\Repository\UserBettingRepository")
 * @ORM\HasLifecycleCallbacks
 */
class UserBetting
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\GameCore\Persistence\Entity\Game", inversedBy="installations")
     * @ORM\JoinColumn(name="game_id", referencedColumnName="id")
     */
    private $game;

    /**
     * @ORM\ManyToOne(targetEntity="App\User\Persistence\Entity\User", inversedBy="installations")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

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

    public function getId()
    {
        return $this->id;
    }

    public function getGame(): ?Game
    {
        return $this->game;
    }

    public function setGame(Game $game): self
    {
        $this->game = $game;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->teamSecond;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

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
     * Gets triggered only on insert

     * @ORM\PrePersist
     */
    public function onPrePersist()
    {
        $this->date = new \DateTime("now");
    }

    /**
     * Gets triggered every time on update

     * @ORM\PreUpdate
     */
    public function onPreUpdate()
    {
        $this->date = new \DateTime("now");
    }
}

