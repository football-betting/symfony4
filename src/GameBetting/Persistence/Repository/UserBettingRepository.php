<?php

namespace App\GameBetting\Persistence\Repository;

use App\GameBetting\Persistence\Entity\UserBetting;
use App\User\Persistence\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Game|null find($id, $lockMode = null, $lockVersion = null)
 * @method Game|null findOneBy(array $criteria, array $orderBy = null)
 * @method Game[]    findAll()
 * @method Game[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserBettingRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, UserBetting::class);
    }

    public function findUserBettingByUserId(User $user, array $games)
    {
        $gameIds = array_map(
            function ($game) {
                return $game->getId();
            },
            $games
        );
        
        return $this->createQueryBuilder('ub')
                    ->add('where', $this->createQueryBuilder('ub')->expr()->in('ub.game', $gameIds))
                    ->where('ub.user = :userId')
                    ->setParameter('userId', $user->getId())
                    ->getQuery()
                    ->getResult()
            ;
    }

    public function findByGameIdAndUserId(int $gameId, int $userId)
    {
        return $this->findOneBy([
            'game' => $gameId,
            'user' => $userId
        ]);
    }
}
