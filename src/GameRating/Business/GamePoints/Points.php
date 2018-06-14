<?php


namespace App\GameRating\Business\GamePoints;


use App\GameRating\Business\GamePoints\Collection\CollectionInterface;
use App\GameRating\Persistence\DataProvider\Result;

class Points implements PointsInterface
{
    /**
     * @var CollectionInterface
     */
    private $collections;

    /**
     * @param CollectionInterface[] $collections
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
            if (!$collection instanceof CollectionInterface) {
                throw new \RuntimeException('Collection: ' . get_class($collection) . 'is not instanceof ' . CollectionInterface::class);
            }
        }
    }


}