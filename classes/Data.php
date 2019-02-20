<?php
/**
 * Created by PhpStorm.
 * Date: 2/19/2019
 * Time: 4:03 PM
 */

namespace App\Model;


abstract class Data
{
    protected $data;

    public function __construct(array $data = [])
    {
        $this->data = $data;
    }

    public function setData($name, $value)
    {
        $this->data[$name] = $value;
    }

    public function getData($name, $default = null)
    {
        return isset($this->data[$name]) ? $this->data[$name] : $default;
    }
}