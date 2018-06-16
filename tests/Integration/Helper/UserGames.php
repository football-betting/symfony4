<?php


namespace App\Tests\Integration\Helper;

use App\GameBetting\Persistence\Entity\UserBetting;

trait UserGames
{
    public function deleteTestUserGames()
    {
        $sql = 'DELETE FROM user_betting WHERE user_id = ' . $this->getUserTwo()->getId() . ' or user_id = ' . $this->getUser()->getId();
        $this->entityManager->getConnection()->prepare($sql)->execute();
    }

    public function createTestFutureGamesUserGames()
    {
        $gameEntity = $this->createTestFutureGames();

        $userBetting = new UserBetting();
        $userBetting->setGame($gameEntity);
        $userBetting->setUser($this->getUser());

        $userBetting->setFirstTeamResult(4);
        $userBetting->setSecondTeamResult(5);


        $this->entityManager->persist($userBetting);
        $this->entityManager->flush();

        return $userBetting;
    }

    public function createTestPastGamesUserGames()
    {
        $gameEntity = $this->createTestPastGames();

        $userBetting = new UserBetting();
        $userBetting->setGame($gameEntity);
        $userBetting->setUser($this->getUser());

        $userBetting->setFirstTeamResult(4);
        $userBetting->setSecondTeamResult(5);


        $this->entityManager->persist($userBetting);
        $this->entityManager->flush();

        return $userBetting;
    }

    public function createTestFutureGamesUserGamesTwo()
    {
        $gameEntity = $this->createTestFutureGames();

        $userBetting = new UserBetting();
        $userBetting->setGame($gameEntity);
        $userBetting->setUser($this->getUser());

        $userBetting->setFirstTeamResult(4);
        $userBetting->setSecondTeamResult(5);


        $this->entityManager->persist($userBetting);
        $this->entityManager->flush();

        return $userBetting;
    }

    public function createTestPastGamesUserGamesTwo()
    {
        $gameEntity = $this->createTestPastGames();

        $userBetting = new UserBetting();
        $userBetting->setGame($gameEntity);
        $userBetting->setUser($this->getUser());

        $userBetting->setFirstTeamResult(3);
        $userBetting->setSecondTeamResult(1);


        $this->entityManager->persist($userBetting);
        $this->entityManager->flush();

        return $userBetting;
    }

}