<?php
/**
 * Created by PhpStorm.
 * User: René
 * Date: 08.09.2018
 * Time: 16:52
 */

namespace App\model;


class AroundTheClock
{

    private $numDarts;

    private $bullIncluded;

    /**
     * @return mixed
     */
    public function getNumDarts()
    {
        return $this->numDarts;
    }

    /**
     * @param mixed $numDarts
     */
    public function setNumDarts($numDarts): void
    {
        $this->numDarts = $numDarts;
    }

    /**
     * @return mixed
     */
    public function getBullIncluded()
    {
        return $this->bullIncluded;
    }

    /**
     * @param mixed $bullIncluded
     */
    public function setBullIncluded($bullIncluded): void
    {
        $this->bullIncluded = $bullIncluded;
    }

}