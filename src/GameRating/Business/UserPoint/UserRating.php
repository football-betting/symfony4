<?php


namespace App\GameRating\Business\UserPoint;


use App\GameRating\Business\UserPoint\Info\UserScore;
use App\GameRating\Persistence\DataProvider\UserScoreWithPosition;


class UserRating implements UserRatingInterface
{
    /**
     * @param UserScore[] $usersScores
     * @return UserScoreWithPosition[]
     */
    public function sortUserByScore(array $usersScores): array
    {
        usort($usersScores, function ($a, $b) {
            return ($a->getScoreSumme() <=> $b->getScoreSumme()) * -1;
        });

        $usersPositionAndScore = [];
        $position = 0;
        $lastPoint = -1;
        $positionForFrontend = 0;

        /** @var UserScore $usersScore */
        foreach ($usersScores as $usersScore) {
            ++$position;
            if ($usersScore->getScoreSumme() !== $lastPoint) {
                $positionForFrontend = $position;
            }
            $usersPositionAndScore[] = new UserScoreWithPosition(
                $positionForFrontend,
                $usersScore
            );
            $lastPoint = $usersScore->getScoreSumme();
        }

        return $usersPositionAndScore;
    }
}