<?php


namespace App\GameRating\Business;


use App\GameRating\Business\GamePoints\PointsInterface;
use App\GameRating\Persistence\DataProvider\Result;

class GameRatingFacade implements GameRatingFacadeInterface
{

    /**
     * @var PointsInterface
     */
    private $points;

    /**
     * @param PointsInterface $points
     */
    public function __construct(PointsInterface $points)
    {
        $this->points = $points;
    }

    /**
     * @param Result $result
     * @return int
     */
    public function getPoints(Result $result)
    {
        return $this->points->get($result);
    }
}