<?php


namespace App\Tests\Integration\Helper;

use App\User\Persistence\Entity\User as UserEntity;

trait User
{
    /**
     * @return UserEntity
     */
    public function getUser(): UserEntity
    {
        $userRepository = $this->entityManager->getRepository(UserEntity::class);
        $userEntity = $userRepository->findOneBy([
            'username' => Config::USER_NAME
        ]);

        if( ! $userEntity instanceof UserEntity ) {
            $userEntity = $this->createUser();
        }

        return $userEntity;
    }

    /**
     * @return UserEntity
     */
    public function getUserTwo(): UserEntity
    {
        $userRepository = $this->entityManager->getRepository(UserEntity::class);
        $userEntity = $userRepository->findOneBy([
            'username' => Config::USER_NAME_TWO
        ]);

        if( ! $userEntity instanceof UserEntity ) {
            $userEntity = $this->createUserTwo();
        }

        return $userEntity;
    }

    /**
     * @param string $username
     */
    public function deleteUserByUsername(string $username): void
    {
        $userRepository = $this->entityManager->getRepository(UserEntity::class);
        $userEntity = $userRepository->findOneBy([
            'username' => $username
        ]);

        if( $userEntity instanceof UserEntity ) {
            $this->entityManager->remove($userEntity);
            $this->entityManager->flush();
        }

    }

    /**
     * @return UserEntity
     */
    private function createUser(): UserEntity
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

    /**
     * @return UserEntity
     */
    private function createUserTwo(): UserEntity
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