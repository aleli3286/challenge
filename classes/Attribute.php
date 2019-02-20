<?php
/**
 * Created by PhpStorm.
 * Date: 2/19/2019
 * Time: 12:11 PM
 */

namespace App\Entity;

use App\Kernel\Container;

class Attribute
{
    const TYPE_TEXT = 'text';
    const TYPE_INTEGER = 'integer';
    const TYPE_BOOLEAN = 'boolean';
    const TYPE_SELECT = 'select';
    const TYPE_DECIMAL = 'decimal';

    public $id;
    public $code;
    public $name;
    public $attributeType;

    private $options;

    public function getOptions()
    {
        if (null !== $this->options) {
            return $this->options;
        }

        return $this->options = Container::getInstance()->get('attribute_option')->findBy(['attribute_id' => $this->id]);
    }

    public function getOption($code)
    {
        $options = array_filter($this->getOptions(), function($option) use ($code) {
            return $option->code == $code;
        });

        if (!count($options)) {
            throw new \RuntimeException(sprintf('Option %s does not exists!', $code));
        }

        return $options[0];
    }

    public function getChoices()
    {
        $option = $this->getOption('choices');

        return unserialize($option->optionValue);
    }
}