<?php

namespace App\GameBetting\Business\Games;

use App\GameBetting\Persistence\DataProvider\GamePastBetting;
use Symfony\Component\Security\Core\User\UserInterface;

interface UserPastGamesInterface
{
    /**
     * @param UserInterface $user
     * @return GamePastBetting[]
     */
    public function get(UserInterface $user): array;
}