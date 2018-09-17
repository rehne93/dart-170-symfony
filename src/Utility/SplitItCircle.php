<?php
/**
 * Created by PhpStorm.
 * User: René
 * Date: 17.09.2018
 * Time: 22:37
 */

namespace App\Utility;



class SplitItCircle
{
    private static $targets = array('15','16','Doubles','17','18','Tripple','19','20','Bull');

    public static function getCurrentRound($pos){
        if($pos > sizeof(SplitItCircle::$targets)-1){
            return "";
        }
        $val =  SplitItCircle::$targets[$pos];
        return $val;
    }
}