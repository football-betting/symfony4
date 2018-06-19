<?php

namespace App\GameBetting\Business\Games;

use App\GameBetting\Persistence\DataProvider\GamePastBetting;
use App\GameCore\Persistence\Entity\Game;
use Symfony\Component\Security\Core\User\UserInterface;

interface UserPastGamesInterface
{
    /**
     * @param UserInterface $user
     * @return GamePastBetting[]
     */
    public function get(UserInterface $user): array;


    /**
     * @param UserInterface $user
     * @return GamePastBetting[]
     */
    public function getActiveGames(UserInterface $user): array;
}