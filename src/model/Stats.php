<?php
/**
 * Created by PhpStorm.
 * User: René
 * Date: 23.10.2018
 * Time: 15:51
 */

namespace App\model;


class Stats
{
    private $user;

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user): void
    {
        $this->user = $user;
    }


}