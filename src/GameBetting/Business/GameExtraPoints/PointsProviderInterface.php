<?php

namespace App\GameBetting\Business\GameExtraPoints;

use Symfony\Component\Security\Core\User\UserInterface;

interface PointsProviderInterface
{
    /**
     * @param UserInterface $user
     * @return int
     */
    public function get(UserInterface $user): int;
}