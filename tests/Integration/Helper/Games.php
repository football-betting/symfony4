<?php


namespace App\Tests\Integration\Helper;

use App\GameCore\Persistence\Entity\Team as TeamEntity;
use App\GameCore\Persistence\Entity\Game as GameEntity;
use App\GameCore\Persistence\Repository\GameRepository;

trait Games
{
    /**
     * @return GameEntity
     */
    public function createTestFutureGames()
    {
        $teamEntityOne = $this->getTeamUnitFutureOne();
        $teamEntityTwo = $this->getTeamUnitFutureTwo();

        $dateTime = new \DateTime(null, new \DateTimeZone('Europe/Berlin'));
        $dateTime->add(new \DateInterval('PT1M'));

        $gameEntity = new GameEntity();
        $gameEntity->setDate($dateTime);
        $gameEntity->setTeamFirst($teamEntityOne);
        $gameEntity->setTeamSecond($teamEntityTwo);
        $gameEntity->setFirstTeamResult(null);
        $gameEntity->setSecondTeamResult(null);
        $this->entityManager->persist($gameEntity);
        $this->entityManager->flush();

        return $gameEntity;
    }

    /**
     * @return GameEntity
     */
    public function createTestFutureGamesSecond()
    {
        $teamEntityOne = $this->getTeamUnitFutureOne();
        $teamEntityThree = $this->getTeamUnitFutureThree();

        $dateTime = new \DateTime(null, new \DateTimeZone('Europe/Berlin'));
        $dateTime->add(new \DateInterval('PT30S'));

        $gameEntity = new GameEntity();
        $gameEntity->setDate($dateTime);
        $gameEntity->setTeamFirst($teamEntityOne);
        $gameEntity->setTeamSecond($teamEntityThree);
        $gameEntity->setFirstTeamResult(null);
        $gameEntity->setSecondTeamResult(null);
        $this->entityManager->persist($gameEntity);
        $this->entityManager->flush();

        return $gameEntity;
    }


    /**
     * @return GameEntity
     * @throws \Exception
     */
    public function createTestPastGames()
    {
        $teamEntityOne = $this->getTeamUnitPastOne();
        $teamEntityTwo = $this->getTeamUnitPastTwo();

        $dateTime = new \DateTime(null, new \DateTimeZone('Europe/Berlin'));
        $dateTime->sub(new \DateInterval('PT1M'));

        $gameEntity = new GameEntity();
        $gameEntity->setDate($dateTime);
        $gameEntity->setTeamFirst($teamEntityOne);
        $gameEntity->setTeamSecond($teamEntityTwo);
        $gameEntity->setFirstTeamResult(0);
        $gameEntity->setSecondTeamResult(1);
        $this->entityManager->persist($gameEntity);
        $this->entityManager->flush();

        return $gameEntity;
    }

    /**
     * @return GameEntity
     * @throws \Exception
     */
    public function createTestPastGamesSecond()
    {
        $teamEntityOne = $this->getTeamUnitPastOne();
        $teamEntityTwo = $this->getTeamUnitPastThree();

        $dateTime = new \DateTime(null, new \DateTimeZone('Europe/Berlin'));
        $dateTime->sub(new \DateInterval('PT30S'));

        $gameEntity = new GameEntity();
        $gameEntity->setDate($dateTime);
        $gameEntity->setTeamFirst($teamEntityOne);
        $gameEntity->setTeamSecond($teamEntityTwo);
        $gameEntity->setFirstTeamResult(null);
        $gameEntity->setSecondTeamResult(null);
        $this->entityManager->persist($gameEntity);
        $this->entityManager->flush();

        return $gameEntity;
    }

    /**
     * @return GameEntity
     * @throws \Exception
     */
    public function createTestPastGamesNotActive()
    {
        $teamEntityOne = $this->getTeamUnitPastThree();
        $teamEntityTwo = $this->getTeamUnitPastTwo();

        $dateTime = new \DateTime(null, new \DateTimeZone('Europe/Berlin'));
        $dateTime->sub(new \DateInterval(GameRepository::GAME_TIME_RANGE));
        $dateTime->sub(new \DateInterval('PT1M'));
        $gameEntity = new GameEntity();
        $gameEntity->setDate($dateTime);
        $gameEntity->setTeamFirst($teamEntityOne);
        $gameEntity->setTeamSecond($teamEntityTwo);
        $gameEntity->setFirstTeamResult(0);
        $gameEntity->setSecondTeamResult(1);
        $this->entityManager->persist($gameEntity);
        $this->entityManager->flush();

        return $gameEntity;
    }

    public function deleteTestGames()
    {
        $ids = [
            $this->getTeamUnitPastOne()->getId(),
            $this->getTeamUnitPastTwo()->getId(),
            $this->getTeamUnitPastThree()->getId(),
            $this->getTeamUnitFutureOne()->getId(),
            $this->getTeamUnitFutureTwo()->getId(),
            $this->getTeamUnitFutureThree()->getId(),
        ];

        $sql = 'DELETE FROM game WHERE team_first_id in (' . implode(',', $ids) . ')';
        $this->entityManager->getConnection()->prepare($sql)->execute();

        $names = [
            Config::TEAM_PAST_ONE,
            Config::TEAM_PAST_TWO,
            Config::TEAM_PAST_THREE,
            Config::TEAM_FUTURE_ONE,
            Config::TEAM_FUTURE_TWO,
            Config::TEAM_FUTURE_THREE,
        ];
        $sql = 'DELETE FROM team WHERE name in (' . substr(json_encode($names), 1, -1) . ')';
        $this->entityManager->getConnection()->prepare($sql)->execute();

    }

    /**
     * @return TeamEntity
     */
    public function getTeamUnitPastOne()
    {
        return $this->getTeamByName(Config::TEAM_PAST_ONE);
    }

    /**
     * @return TeamEntity
     */
    public function getTeamUnitPastTwo()
    {
        return $this->getTeamByName(Config::TEAM_PAST_TWO);
    }

    /**
     * @return TeamEntity
     */
    public function getTeamUnitPastThree()
    {
        return $this->getTeamByName(Config::TEAM_PAST_THREE);
    }


    /**
     * @return TeamEntity
     */
    public function getTeamUnitFutureOne()
    {
        return $this->getTeamByName(Config::TEAM_FUTURE_ONE);
    }

    /**
     * @return TeamEntity
     */
    public function getTeamUnitFutureTwo()
    {
        return $this->getTeamByName(Config::TEAM_FUTURE_TWO);
    }

    /**
     * @return TeamEntity
     */
    public function getTeamUnitFutureThree()
    {
        return $this->getTeamByName(Config::TEAM_FUTURE_THREE);
    }

    /**
     * @param $name
     * @return TeamEntity
     */
    private function getTeamByName(string $name)
    {
        $teamRepository = $this->entityManager->getRepository(TeamEntity::class);
        $teamEntity = $teamRepository->findOneBy([
            'name' => $name
        ]);

        if (!$teamEntity instanceof TeamEntity) {
            $teamEntity = new TeamEntity();
            $teamEntity->setName($name);
            $teamEntity->setImg($name);
            $this->entityManager->persist($teamEntity);
            $this->entityManager->flush();
        }

        return $teamEntity;
    }
}