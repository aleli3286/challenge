<?php
/**
 * Created by PhpStorm.
 * Date: 2/19/2019
 * Time: 9:58 PM
 */

namespace App\Controller;


use App\Http\Session;
use App\Kernel\Container;

class Filter
{
    /**
     * @var Session
     */
    private $session;

    public function __construct()
    {
        $this->session = Container::getInstance()->get('session');
    }

    public function setFilter($filter)
    {
        $filter = array_filter($filter, function($value) {
            return (boolean)trim($value);
        });

        $this->session->set('filter', $filter);
    }

    public function getConditions()
    {
        $attributes = Container::getInstance()->get('attribute')->getAll();

        $filter = $this->session->get('filter', []);

        $conditions = [];
        if (isset($filter['category_id'])) {
            $conditions[] = [
                'operator' => '=',
                'field' => 'category_id',
                'value' => $filter['category_id']
            ];
        }
        if (isset($filter['name'])) {
            $conditions[] = [
                'operator' => 'LIKE',
                'field' => 'name',
                'value' => sprintf('%%%s%%', $filter['name'])
            ];
        }
        if (isset($filter['description'])) {
            $conditions[] = [
                'operator' => 'LIKE',
                'field' => 'description',
                'value' => sprintf('%%%s%%', $filter['description'])
            ];
        }
        if (isset($filter['price'])) {
            $conditions[] = [
                'operator' => '=',
                'field' => 'price',
                'value' => $filter['price']
            ];
        }

        foreach ($attributes as $attribute) {
            if (isset($filter[$attribute->code])) {
                $comparisionOperator = '=';
                if ($attribute->attributeType == 'text') {
                    $comparisionOperator = 'LIKE';
                }

                $conditions[] = [
                    'operator' => $comparisionOperator,
                    'field' => $attribute->code,
                    'value' => $comparisionOperator == 'LIKE' ? sprintf('%%%s%%', $filter[$attribute->code]) : $filter[$attribute->code],
                    'cast_as' => $attribute->attributeType == 'decimal' ? 'DECIMAL(10,2)' : false
                ];
            }
        }

        return $conditions;
    }
}