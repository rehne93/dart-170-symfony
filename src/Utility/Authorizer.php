<?php
/**
 * Created by PhpStorm.
 * User: René
 * Date: 08.09.2018
 * Time: 16:46
 */

namespace App\Utility;


use Symfony\Component\HttpFoundation\Request;

class Authorizer
{

    public function isAuthorized(Request $request)
    {
        $cookie = $request->cookies;
        if ($cookie->has('player')) {
            return $cookie->get('player');
        } else {
            return "";
        }
    }
}