<?php
/**
 * Created by PhpStorm.
 * Date: 2/19/2019
 * Time: 2:48 PM
 */

namespace App\Repository;

use App\Entity\Product;
use App\Kernel\Container;
use App\Model\CustomAttribute;

class ProductRepository extends Repository
{
    protected $fieldsMap = [
        'id' => 'id',
        'name' => 'name',
        'description' => 'description',
        'image' => 'image',
        'price' => 'price',
        'category_id' => 'categoryId'
    ];
    protected $tableName = 'product';
    protected $className = Product::class;

    public function getAll()
    {
        $attributes = Container::getInstance()->get('attribute')->getAll();

        $parts = [
            'select' => [],
            'from' => [
                'main_table' => $this->tableName
            ],
            'join' => [],
            'where' => []
        ];

        foreach (array_keys($this->fieldsMap) as $name) {
            $parts['select'][$name] = sprintf('main_table.%s', $name);
        }
        foreach ($attributes as $attribute) {
            $parts['select'][sprintf('attr_%s', $attribute->code)] = sprintf('tbl_attr_%s.attribute_value', $attribute->code);

            $parts['join'][sprintf('tbl_attr_%s', $attribute->code)] = [
                'type' => 'left',
                'table_name' => 'attribute_value',
                'condition' => sprintf('tbl_attr_%s.product_id = main_table.id AND tbl_attr_%s.attribute_id = %s', $attribute->code, $attribute->code, $attribute->id)
            ];
        }

        $selectFields = [];
        foreach ($parts['select'] as $alias => $fieldName) {
            $selectFields[] = sprintf(
                '%s%s',
                $fieldName,
                !is_numeric($alias) ? sprintf(' AS %s', $alias) : ''
            );
        }

        $fromFields = [];
        foreach ($parts['from'] as $alias => $tableName) {
            $fromFields[] = sprintf(
                '%s%s',
                $tableName,
                !is_numeric($alias) ? sprintf(' AS %s', $alias) : ''
            );
        }

        $joinFields = [];
        foreach ($parts['join'] as $alias => $join) {
            $joinFields[] = sprintf(
                ' %sJOIN %s%s ON %s',
                strtoupper($join['type']) . ' ',
                $join['table_name'],
                sprintf(' AS %s', $alias),
                $join['condition']
            );
        }

        $sql = sprintf(
            'SELECT %s FROM %s%s',
            implode(', ', $selectFields),
            implode(', ', $fromFields),
            implode('', $joinFields)
        );

        $rows = $this->connection->query($sql);

        /** @var Product[] $products */
        $products = $this->populateWithResults($rows);

        foreach ($rows as $index => $row) {
            foreach ($attributes as $attribute) {
                $customAttribute = new CustomAttribute($attribute);
                $customAttribute->value = $row[sprintf('attr_%s', $attribute->code)];
                $products[$index]->setCustomAttribute($customAttribute);
            }
        }

        return $products;
    }

    public function findBy(array $conditions)
    {
        $attributes = Container::getInstance()->get('attribute')->getAll();

        $parts = [
            'select' => [],
            'from' => [
                'main_table' => $this->tableName
            ],
            'join' => [],
            'where' => [],
            'having' => []
        ];

        foreach (array_keys($this->fieldsMap) as $name) {
            $parts['select'][$name] = sprintf('main_table.%s', $name);
        }
        foreach ($attributes as $attribute) {
            $parts['select'][sprintf('attr_%s', $attribute->code)] = sprintf('tbl_attr_%s.attribute_value', $attribute->code);

            $parts['join'][sprintf('tbl_attr_%s', $attribute->code)] = [
                'type' => 'left',
                'table_name' => 'attribute_value',
                'condition' => sprintf('tbl_attr_%s.product_id = main_table.id AND tbl_attr_%s.attribute_id = %s', $attribute->code, $attribute->code, $attribute->id)
            ];
        }

        $selectFields = [];
        foreach ($parts['select'] as $alias => $fieldName) {
            $selectFields[] = sprintf(
                '%s%s',
                $fieldName,
                !is_numeric($alias) ? sprintf(' AS %s', $alias) : ''
            );
        }

        $fromFields = [];
        foreach ($parts['from'] as $alias => $tableName) {
            $fromFields[] = sprintf(
                '%s%s',
                $tableName,
                !is_numeric($alias) ? sprintf(' AS %s', $alias) : ''
            );
        }

        $joinFields = [];
        foreach ($parts['join'] as $alias => $join) {
            $joinFields[] = sprintf(
                ' %sJOIN %s%s ON %s',
                strtoupper($join['type']) . ' ',
                $join['table_name'],
                sprintf(' AS %s', $alias),
                $join['condition']
            );
        }

        $whereFields = $havingFields = [];
        foreach ($conditions as $condition) {
            if (false !== array_search($condition['field'], array_keys($this->fieldsMap))) {
                $whereFields[] = sprintf(
                    'main_table.%s %s \'%s\'',
                    $condition['field'],
                    $condition['operator'],
                    $condition['value']
                );
            } else {
                $havingFields[] = sprintf(
                    '%sattr_%s%s %s \'%s\'',
                    $condition['cast_as'] ? 'CAST(' : '',
                    $condition['field'],
                    $condition['cast_as'] ? sprintf(' AS %s)', $condition['cast_as']) : '',
                    $condition['operator'],
                    $condition['value']
                );
            }
        }

        $sql = sprintf(
            'SELECT %s FROM %s%s%s%s',
            implode(', ', $selectFields),
            implode(', ', $fromFields),
            implode('', $joinFields),
            $whereFields ? sprintf(' WHERE (%s)', implode(') AND (', $whereFields)) : '',
            $havingFields ? sprintf(' HAVING (%s)', implode(') AND (', $havingFields)) : ''
        );

        $rows = $this->connection->query($sql);

        /** @var Product[] $products */
        $products = $this->populateWithResults($rows);

        foreach ($rows as $index => $row) {
            foreach ($attributes as $attribute) {
                $customAttribute = new CustomAttribute($attribute);
                $customAttribute->value = $row[sprintf('attr_%s', $attribute->code)];
                $products[$index]->setCustomAttribute($customAttribute);
            }
        }

        return $products;
    }
}