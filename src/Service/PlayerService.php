<?php
/**
 * Created by PhpStorm.
 * User: René
 * Date: 23.10.2018
 * Time: 16:06
 */

namespace App\Service;


use PlayerQuery;

class PlayerService
{
    public function getAllPersonNames()
    {
        return PlayerQuery::create()->find()->getColumnValues('name');
    }
}