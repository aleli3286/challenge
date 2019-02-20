<?php
/**
 * Created by PhpStorm.
 * Date: 2/19/2019
 * Time: 12:12 PM
 */

namespace App\Entity;

use App\Repository\Repository;

class AttributeRepository extends Repository
{
    protected $fieldsMap = [
        'id' => 'id',
        'name' => 'name',
        'code' => 'code',
        'attribute_type' => 'attributeType',
        'is_visible' => 'isVisible'
    ];
    protected $tableName = 'attribute';
    protected $className = Attribute::class;
}