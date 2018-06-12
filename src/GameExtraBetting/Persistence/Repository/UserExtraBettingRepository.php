<?php

namespace App\GameExtraBetting\Persistence\Repository;

use App\GameBetting\Persistence\Entity\UserBetting;
use App\GameExtraBetting\Persistence\Entity\UserExtraBetting;
use App\User\Persistence\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Game|null find($id, $lockMode = null, $lockVersion = null)
 * @method Game|null findOneBy(array $criteria, array $orderBy = null)
 * @method Game[]    findAll()
 * @method Game[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserExtraBettingRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, UserExtraBetting::class);
    }
}
