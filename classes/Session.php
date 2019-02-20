<?php
/**
 * Created by PhpStorm.
 * Date: 2/19/2019
 * Time: 11:55 AM
 */

namespace App\Http;

class Session
{
    public function set($name, $value = null)
    {
        $_SESSION[$name] = $value;
    }

    public function get($name, $default = null)
    {
        return isset($_SESSION[$name]) ? $_SESSION[$name] : $default;
    }
}