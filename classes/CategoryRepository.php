<?php
/**
 * Created by PhpStorm.
 * Date: 2/20/2019
 * Time: 10:11 AM
 */

namespace App\Repository;

use App\Entity\Category;

class CategoryRepository extends Repository
{
    protected $fieldsMap = [
        'id' => 'id',
        'name' => 'name'
    ];
    protected $tableName = 'category';
    protected $className = Category::class;
}