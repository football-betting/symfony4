<?php


namespace App\GameBetting\Business\GameExtraPoints;


use App\GameBetting\Business\GameExtraPoints\Score\ScoreInterface;
use App\GameBetting\Persistence\DataProvider\ExtraResult;

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
     * @param ExtraResult $extraResult
     * @return int
     */
    public function get(ExtraResult $extraResult): int
    {
        $this->checkCollection();

        usort($this->collections, function ($a, $b) {
            return $a->getScore() <=> $b->getScore();
        });
        $this->collections = array_reverse($this->collections);

        $score = 0;

        foreach ($this->collections as $collection) {
            if ($collection->check($extraResult) === true) {
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