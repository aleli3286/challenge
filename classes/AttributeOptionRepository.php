<?php
/**
 * Created by PhpStorm.
 * Date: 2/19/2019
 * Time: 2:15 PM
 */

namespace App\Repository;

use App\Entity\AttributeOption;

class AttributeOptionRepository extends Repository
{
    protected $fieldsMap = [
        'id' => 'id',
        'attribute_id' => 'attributeId',
        'code' => 'code',
        'option_value' => 'optionValue'
    ];
    protected $tableName = 'attribute_option';
    protected $className = AttributeOption::class;

}