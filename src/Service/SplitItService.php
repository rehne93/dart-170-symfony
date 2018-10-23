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

    /**
     * SplitItService constructor.
     * @param $name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }


    public function getSplitScoreAverage()
    {
        $pService = new PlayerService();
        $id = $pService->getPlayerId($this->name);

        $scores = SplitScoreQuery::create()->findByPlayerid($id)->getColumnValues('finalScore');
        if (sizeof($scores) == 0) return 0;

        return round(array_sum($scores) / sizeof($scores), 3);
    }

}