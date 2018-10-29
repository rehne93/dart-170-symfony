<?php
/**
 * Created by PhpStorm.
 * User: René
 * Date: 23.10.2018
 * Time: 21:06
 */

namespace App\Service;


use SplitScoreQuery;

class SplitItService
{

    private $name;
    private $playerId = -1;

    /**
     * SplitItService constructor.
     * @param $name
     */
    public function __construct($name)
    {
        $this->name = $name;
        $pService = new PlayerService();
        $this->playerId = $pService->getPlayerId($this->name);

    }


    public function getSplitScoreAverage()
    {
        $scores = SplitScoreQuery::create()->findByPlayerid($this->playerId)->getColumnValues('finalScore');
        if (sizeof($scores) == 0) return 0;

        return round(array_sum($scores) / sizeof($scores), 3);
    }

    public function getHighestSplitscore()
    {
        $highScore = SplitScoreQuery::create()->orderByFinalscore('desc')->findOneByPlayerid($this->playerId);
        return $highScore->getFinalscore();
    }

    public function getLowestSplitscore()
    {
        $highScore = SplitScoreQuery::create()->orderByFinalscore()->findOneByPlayerid($this->playerId);
        return $highScore->getFinalscore();
    }


}