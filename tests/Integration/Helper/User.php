<?php


namespace App\Tests\Integration\Helper;

use App\User\Persistence\Entity\User as UserEntity;

trait User
{
    public function getUser()
    {
        $teamRepository = $this->entityManager->getRepository(UserEntity::class);
        $userEntity = $teamRepository->findOneBy([
            'username' => Config::USER_NAME
        ]);

        if( ! $userEntity instanceof UserEntity ) {
            $userEntity = $this->createUser();
        }

        return $userEntity;
    }

    public function getUserTwo()
    {
        $teamRepository = $this->entityManager->getRepository(UserEntity::class);
        $userEntity = $teamRepository->findOneBy([
            'username' => Config::USER_NAME_TWO
        ]);

        if( ! $userEntity instanceof UserEntity ) {
            dump(__FUNCTION__ .' / '. __FILE__ .' / '. __LINE__);
            $userEntity = $this->createUserTwo();
            dump($userEntity);
        }

        return $userEntity;
    }

    private function createUser()
    {
        $user = new UserEntity();
        $user->setEmail(Config::USER_EMAIL);
        $user->setUsername(Config::USER_NAME);
        $user->setPlainPassword(Config::USER_PASS);

        $encoder = self::$container->get('security.password_encoder');
        $encoded = $encoder->encodePassword($user, Config::USER_PASS);
        $user->setPassword($encoded);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }

    private function createUserTwo()
    {
        $user = new UserEntity();
        $user->setEmail(Config::USER_EMAIL_TWO);
        $user->setUsername(Config::USER_NAME_TWO);
        $user->setPlainPassword(Config::USER_PASS_TWO);

        $encoder = self::$container->get('security.password_encoder');
        $encoded = $encoder->encodePassword($user, Config::USER_PASS_TWO);
        $user->setPassword($encoded);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }
}