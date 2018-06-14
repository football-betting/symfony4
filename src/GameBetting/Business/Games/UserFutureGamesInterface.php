<?php

namespace App\GameBetting\Business\Games;

use Symfony\Component\Security\Core\User\UserInterface;

interface UserFutureGamesInterface
{
    public function get(UserInterface $user): array;
}