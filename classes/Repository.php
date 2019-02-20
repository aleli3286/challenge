<?php
/**
 * Created by PhpStorm.
 * Date: 2/19/2019
 * Time: 12:23 PM
 */

namespace App\Repository;

use App\Kernel\Connection;
use App\Kernel\Container;

abstract class Repository
{
    protected $fieldsMap;
    protected $tableName;
    protected $className;

    /** @var Connection */
    protected $connection;

    public function __construct()
    {
        /** @var Connection connection */
        $this->connection = Container::getInstance()->get('connection');
    }

    public function getAll()
    {
        $fields = array_keys($this->fieldsMap);

        $statement = sprintf(
            'SELECT %s FROM %s',
            implode(', ', $fields),
            $this->tableName
        );

        $result = $this->connection->query($statement);

        $populatedObjects = $this->populateWithResults($result);

        return $populatedObjects;
    }

    public function findBy(array $conditions)
    {
        $where = [];
        foreach ($conditions as $field => $value) {
            if (!isset($this->fieldsMap[$field])) {
                throw new \RuntimeException(sprintf('Field %s not in table %s', $field, $this->tableName));
            }

            $where[] = sprintf('%s = %s', $field, $value);
        }

        $sql = sprintf(
            'SELECT %s FROM %s%s',
            implode(', ', array_keys($this->fieldsMap)),
            $this->tableName,
            $where ? sprintf(' WHERE %s', implode(' AND ', $where)) : ''
        );

        $rows = $this->connection->query($sql);

        return $this->populateWithResults($rows);
    }

    public function findOneBy(array $conditions)
    {
        $records = $this->findBy($conditions);

        return $records ? $records[0] : null;
    }

    protected function populateWithResults($rows)
    {
        $result = [];

        foreach ($rows as $row) {
            $object = new $this->className();

            foreach ($this->fieldsMap as $fieldName => $method) {
                if (isset($row[$fieldName])) {
                    $object->{$method} = $row[$fieldName];
                }
            }

            $result[] = $object;
        }

        return $result;
    }

    public function getTableName()
    {
        return $this->tableName;
    }
}