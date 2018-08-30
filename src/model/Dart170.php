<?php
/**
 * Created by PhpStorm.
 * User: René
 * Date: 30.08.2018
 * Time: 15:54
 */

namespace App\model;


class Dart170
{
    private $numRounds;
    private $date;

    /**
     * @return mixed
     */
    public function getNumRounds()
    {
        return $this->numRounds;
    }

    /**
     * @param mixed $numRounds
     */
    public function setNumRounds($numRounds): void
    {
        $this->numRounds = $numRounds;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param DateTime $date
     */
    public function setDate(\DateTime $date): void
    {
        $this->date = $date;
    }


}