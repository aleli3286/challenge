<?php
/**
 * Created by PhpStorm.
 * Date: 2/19/2019
 * Time: 4:14 PM
 */

namespace App\Repository;

use App\Entity\AttributeValue;

class AttributeValueRepository extends Repository
{
    protected $fieldsMap = [
        'id' => 'id',
        'attribute_id' => 'attributeId',
        'productId' => 'productId',
        'attribute_value' => 'attributeValue'
    ];
    protected $tableName = 'attribute_value';
    protected $className = AttributeValue::class;
}