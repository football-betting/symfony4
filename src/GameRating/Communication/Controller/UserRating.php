<?php

namespace App\GameRating\Communication\Controller;

use App\GameBetting\Business\Games\UserPastGamesInterface;
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
     * @var UserPastGamesInterface
     */
    private $userPastGames;

    /**
     * @param GameRatingFacadeInterface $gameRatingFacade
     * @param UserPastGamesInterface $userPastGames
     */
    public function __construct(GameRatingFacadeInterface $gameRatingFacade, UserPastGamesInterface $userPastGames)
    {
        $this->gameRatingFacade = $gameRatingFacade;
        $this->userPastGames = $userPastGames;
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
     * @Route("/pastgame/{userId}", name="game_past_games_by_users")
     */
    public function pastGameByUserId(int $userId)
    {

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
            if (isset($userScoreWithPositions[$i])) {
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