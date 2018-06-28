<?php


namespace App\GameApi\Business\ApiFootballData\Import;


use App\GameApi\Business\ApiFootballData\ClientInterface;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManager;
use App\GameCore\Persistence\Entity\Team as TeamEntity;
use Doctrine\ORM\EntityManagerInterface;

class Team implements TeamInterface
{
    /**
     * @var ClientInterface
     */
    private $client;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @param ClientInterface $client
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(ClientInterface $client, EntityManagerInterface $entityManager)
    {
        $this->client = $client;
        $this->entityManager = $entityManager;
    }


    public function import() : void
    {
        $teams = $this->client->getTeams();
        $teamRepository = $this->entityManager->getRepository(TeamEntity::class);
        foreach ($teams['teams'] as $team) {
            $teamEntity = $teamRepository->findOneBy([
                'name' => $team['name']
            ]);

            if (!$teamEntity instanceof TeamEntity) {
                $teamEntity = new TeamEntity();
            }
            $teamEntity->setName($team['name']);
            $teamEntity->setImg($team['crestUrl']);
            $this->entityManager->persist($teamEntity);
        }
        $this->entityManager->flush();
    }

}