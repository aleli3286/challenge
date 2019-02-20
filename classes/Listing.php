<?php
/**
 * Created by PhpStorm.
 * Date: 2/19/2019
 * Time: 2:53 PM
 */

namespace App\Controller;

use App\Entity\Product;
use App\Kernel\Container;

class Listing
{
    /**
     * @return Product[]
     */
    public function getProducts()
    {
        $repository = Container::getInstance()->get('product');

        $filter = new Filter();
        $conditions = $filter->getConditions();

        if ($conditions) {
            $products = $repository->findby($conditions);
        } else {
            $products = $repository->getAll();
        }

        return $products;
    }
}