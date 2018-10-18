<?php
/**
 * Created by PhpStorm.
 * User: René
 * Date: 17.09.2018
 * Time: 22:10
 */

namespace App\model;


use JsonSerializable;

class SplitIt implements JsonSerializable
{

    private $currentScore = 40;
    private $score;
    private $currentRound;

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

    /**
     * @return mixed
     */
    public function getCurrentRound()
    {
        return $this->currentRound;
    }

    /**
     * @param mixed $currentRound
     */
    public function setCurrentRound($currentRound): void
    {
        $this->currentRound = $currentRound;
    }


    public function jsonSerialize()
    {
        return [
            'currentScore' => $this->getCurrentScore(),
            'score' => $this->getScore(),
            'currentRound' => $this->getCurrentRound()
        ];
    }

    public function set($jsonData)
    {
        foreach ($jsonData AS $key => $value) $this->{$key} = $value;
    }

}