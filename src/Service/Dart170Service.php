<?php
/**
 * Created by PhpStorm.
 * User: René
 * Date: 23.10.2018
 * Time: 20:53
 */

namespace App\Service;


use App\model\Dart170;
use GameQuery;

class Dart170Service
{

    private $name;

    /**
     * Dart170Service constructor.
     * @param $name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }


    public function getAllTimeAverage()
    {
        $pService = new PlayerService();
        $id = $pService->getPlayerId($this->name);
        $games = GameQuery::create()->findByPlayerid($id)->getColumnValues('rounds');
        $score = array_sum($games);
        if (sizeof($games) == 0) {
            return 0;
        } else {
            return round($score / sizeof($games), 3);
        }

    }
}