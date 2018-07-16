<?php


namespace App\GameBetting\Business\GameExtraPoints;


use App\GameBetting\Business\GameExtraPoints\Score\ScoreInterface;
use App\GameBetting\Persistence\DataProvider\ExtraResult;
use App\GameExtraBetting\Persistence\Entity\UserExtraBetting;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class PointsProvider implements PointsProviderInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var PointsInterface
     */
    private $points;

    /**
     * @param EntityManagerInterface $entityManager
     * @param PointsInterface $points
     */
    public function __construct(EntityManagerInterface $entityManager, PointsInterface $points)
    {
        $this->entityManager = $entityManager;
        $this->points = $points;
    }


    /**
     * @param UserInterface $user
     * @return int
     */
    public function get(UserInterface $user) : int
    {
        $extraScore = 0;
        /** @var UserExtraBetting[] $userExterBettings */
        $userExterBettings = $this->entityManager->getRepository(UserExtraBetting::class)->getByUser($user);
        foreach ($userExterBettings as $userExterBetting) {
            $extraResult = new ExtraResult(
                (int)$userExterBetting->getType(),
                (int)$userExterBetting->getText()
            );
            $extraScore = $this->points->get($extraResult);
        }

        return $extraScore;
    }


}