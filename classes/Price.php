<?php
/**
 * Created by PhpStorm.
 * Date: 2/19/2019
 * Time: 7:16 PM
 */

namespace App\Model;

use App\Entity\Product;

class Price
{
    public function getPrice(Product $product)
    {
        $result = [
            'original' => $product->price,
            'special' => false
        ];

        if ('Pets' == $product->getCategory()->name
            && 'dog' == $product->getCustomAttribute('pet_type')->value
            && $product->getCustomAttribute('age')->value > $product->getCustomAttribute('lifespan')->value / 2) {
            $result['special'] = round($product->price / 2, 2);
        }

        return $result;
    }
}