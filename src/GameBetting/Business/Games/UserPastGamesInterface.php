<?php

namespace App\GameBetting\Business\Games;

use Symfony\Component\Security\Core\User\UserInterface;

interface UserPastGamesInterface
{
    public function get(UserInterface $user): array;
}