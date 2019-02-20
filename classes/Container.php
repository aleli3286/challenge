<?php
/**
 * Created by PhpStorm.
 * Date: 2/19/2019
 * Time: 11:59 AM
 */

namespace App\Kernel;

class Container
{
    private static $instance;

    private $services;

    public static function getInstance()
    {
        if (null === self::$instance) {
            self::$instance = new Container();
        }

        return self::$instance;
    }

    public function set($name, $service)
    {
        $this->services[strtolower($name)] = $service;
    }

    public function get($name)
    {
        if (!isset($this->services[$name])) {
            throw new \RuntimeException('Service not found');
        }

        return $this->services[$name];
    }
}