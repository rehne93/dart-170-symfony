<?php
/**
 * Created by PhpStorm.
 * User: René
 * Date: 17.09.2018
 * Time: 22:10
 */

namespace App\model;


class SplitIt
{

    private $currentScore = 40;
    private $score;

    /**
     * @return int
     */
    public function getCurrentScore(): int
    {
        return $this->currentScore;
    }

    /**
     * @param int $currentScore
     */
    public function setCurrentScore(int $currentScore): void
    {
        $this->currentScore = $currentScore;
    }



    /**
     * @return mixed
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * @param mixed $score
     */
    public function setScore($score): void
    {
        $this->score = $score;
    }


}