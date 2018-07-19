<?php

namespace App\GameExtraBetting\Persistence\Repository;

use App\GameBetting\Persistence\Entity\UserBetting;
use App\GameExtraBetting\Persistence\Entity\UserExtraBetting;
use App\User\Persistence\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @method UserExtraBetting|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserExtraBetting|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserExtraBetting[]    findAll()
 * @method UserExtraBetting[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserExtraBettingRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, UserExtraBetting::class);
    }

    /**
     * @param UserInterface $user
     * @return UserExtraBetting[]
     */
    public function getByUser(UserInterface $user)
    {
        return $this->findBy(['user' => $user->getId()]);
    }
}
