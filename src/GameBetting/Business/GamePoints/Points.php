<?php


namespace App\GameBetting\Business\GamePoints;


use App\GameBetting\Business\GamePoints\Score\ScoreInterface;
use App\GameBetting\Persistence\DataProvider\Result;

class Points implements PointsInterface
{
    /**
     * @var ScoreInterface
     */
    private $collections;

    /**
     * @param ScoreInterface[] $collections
     */
    public function __construct(...$collections)
    {
        $this->collections = $collections;
    }

    /**
     * @param Result $result
     * @return int
     */
    public function get(Result $result): int
    {
        $this->checkCollection();

        usort($this->collections, function ($a, $b) {
            return $a->getScore() <=> $b->getScore();
        });
        $this->collections = array_reverse($this->collections);

        foreach ($this->collections as $collection) {
            if ($collection->check($result) === true) {
                $score = $collection->getScore();
                break;
            }
        }

        return $score;
    }


    private function checkCollection()
    {
        foreach ($this->collections as $collection) {
            if (!$collection instanceof ScoreInterface) {
                throw new \RuntimeException('Collection: ' . get_class($collection) . 'is not instanceof ' . ScoreInterface::class);
            }
        }
    }


}