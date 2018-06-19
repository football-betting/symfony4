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
    const GAME_TIME_RANGE = 'PT115M';

    /**
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Game::class);
    }

    /**
     * @return Game[]
     */
    public function findFutureGames()
    {
        $qb = $this->createQueryBuilder('game');
        $qb->where('game.date > :date')
            ->setParameter('date', new \DateTime())
            ->orderBy('game.date', 'ASC');

        return $qb->getQuery()->getResult();
    }

    /**
     * @return Game[]
     */
    public function findPastGames()
    {
        $qb = $this->createQueryBuilder('game');
        $qb->where('game.date <= :date')
            ->setParameter('date', new \DateTime())
            ->orderBy('game.date', 'ASC');

        return $qb->getQuery()->getResult();
    }

    /**
     * @return Game[]
     * @throws \Exception
     */
    public function findActiveGames()
    {
        $dateGameStartRange = new \DateTime();
        $dateGameStartRange->sub(new \DateInterval(self::GAME_TIME_RANGE));

        $qb = $this->createQueryBuilder('game');
        $qb->where('game.date <= :dateNow');
        $qb->andWhere('game.date >= :dateGameStartRange');
        $qb->setParameter('dateNow', new \DateTime());
        $qb->setParameter('dateGameStartRange', $dateGameStartRange);
        $qb->orderBy('game.date', 'ASC');
        
        return $qb->getQuery()->getResult();
    }
}
