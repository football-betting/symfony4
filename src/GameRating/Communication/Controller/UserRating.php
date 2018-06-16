<?php

namespace App\GameRating\Communication\Controller;

use App\GameRating\Business\GameRatingFacadeInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class UserRating extends Controller
{
    /**
     * @var GameRatingFacadeInterface
     */
    private $gameRatingFacade;

    /**
     * @param GameRatingFacadeInterface $gameRatingFacade
     */
    public function __construct(GameRatingFacadeInterface $gameRatingFacade)
    {
        $this->gameRatingFacade = $gameRatingFacade;
    }

    /**
     * @Route("/users/", name="game_rating_users")
     */
    public function users()
    {
        $userScoreWithPositions = $this->gameRatingFacade->getUserScoreWithPosition();
        return $this->render(
            'game_rating/user_rating/users.html.twig',
            [
                'userScoreWithPositions' => $userScoreWithPositions,
            ]
        );
    }

    /**
     * @Route("/myInfo/", name="game_rating_my_info")
     */
    public function myInfo()
    {
        $userScoreWithPositions = $this->gameRatingFacade->getUserScoreWithPosition();
        $myScoreWithPositions = false;
        $userId = $this->getUser()->getId();
        foreach ($userScoreWithPositions as $userScoreWithPosition) {
            if ($userScoreWithPosition->getUserScore()->getUser()->getId() === $userId) {
                $myScoreWithPositions = $userScoreWithPosition;
                break;
            }
        }
        return $this->render(
            'game_rating/user_rating/my_info.html.twig',
            [
                'myScoreWithPositions' => $myScoreWithPositions,
            ]
        );
    }

    /**
     * @Route("/ratingTop3/", name="game_rating_top_three")
     */
    public function ratingTopThree()
    {
        $userScoreWithPositions = $this->gameRatingFacade->getUserScoreWithPosition();
        $topTree = [];

        for ($i = 0; $i < 3; $i++) {
            if(isset($userScoreWithPositions[$i])) {
                $topTree[] = $userScoreWithPositions[$i];
            }
        }

        return $this->render(
            'game_rating/user_rating/top_three.html.twig',
            [
                'userScoreWithPositions' => $topTree,
            ]
        );
    }
}