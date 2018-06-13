<?php

namespace App\GameExtraBetting\Persistence\Entity;

use App\GameCore\Persistence\Entity\Game;
use App\User\Persistence\Entity\User;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\GameExtraBetting\Persistence\Repository\UserExtraBettingRepository")
 */
class UserExtraBetting
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

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
     * @ORM\Column(type="integer", nullable=false)
     */
    private $type;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private $text;

    public function getId()
    {
        return $this->id;
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

    /**
     * @return int|null
     */
    public function getType() : ?int
    {
        return $this->type;
    }

    /**
     * @param int $type
     * @return UserExtraBetting
     */
    public function setType(int $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getText() : ?string
    {
        return $this->text;
    }

    /**
     * @param string $text
     * @return UserExtraBetting
     */
    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }


}

