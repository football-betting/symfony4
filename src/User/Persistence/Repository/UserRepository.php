<?php


namespace App\User\Persistence\Repository;

use App\User\Persistence\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method DataInfo|null find($id, $lockMode = null, $lockVersion = null)
 * @method DataInfo|null findOneBy(array $criteria, array $orderBy = null)
 * @method DataInfo[]    findAll()
 * @method DataInfo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, User::class);
    }
}