<?php
/**
 * Created by PhpStorm.
 * Date: 2/20/2019
 * Time: 12:15 AM
 */

namespace App\Model;

use App\Entity\Attribute;

class CustomAttribute
{
    private $attribute;
    public $value;

    public function __construct(Attribute $attribute)
    {
        $this->attribute = $attribute;
    }

    public function getAttribute()
    {
        return $this->attribute;
    }

    public function getDisplayValue()
    {
        $displayValue = $this->value;

        if ($this->attribute->attributeType == 'select') {
            $choices = \unserialize($this->attribute->getOption('choices')->optionValue);
            $displayValue = isset($choices[$this->value]) ? $choices[$this->value] : '';
        }

        return $displayValue;
    }

    public function setValue()
    {
        return $this->value;
    }

//    public function __toString()
//    {
//        return $this->getDisplayValue();
//    }
}