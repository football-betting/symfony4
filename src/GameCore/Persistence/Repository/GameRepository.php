<?php

namespace App\GameCore\Persistence\Repository;

use App\GameCore\Persistence\Entity\Game;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Game|null find($id, $lockMode = null, $lockVersion = null)
 * @method Game|null findOneBy(array $criteria, array $orderBy = null)
 * @method Game[]    findAll()
 * @method Game[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GameRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Game::class);
    }


    public function findFutureGames()
    {
        $qb = $this->createQueryBuilder('game');
        $qb->where('game.date > :date')
           ->setParameter('date', new \DateTime())
            ->orderBy('game.date', 'ASC');

        return $qb->getQuery()->getResult();
    }

    public function findPastGames()
    {
        $qb = $this->createQueryBuilder('game');
        $qb->where('game.date <= :date')
            ->setParameter('date', new \DateTime())
            ->orderBy('game.date', 'ASC');

        return $qb->getQuery()->getResult();
    }
}
