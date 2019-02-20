<?php
/**
 * Created by PhpStorm.
 * Date: 2/19/2019
 * Time: 9:19 AM
 */

namespace App\Kernel;

class Connection
{
    private $host;
    private $dbName;
    private $user;
    private $password;

    /** @var mysqli */
    private $connection;

    public function __construct($host, $dbName, $user, $password = '')
    {
        $this->host = $host;
        $this->dbName = $dbName;
        $this->user = $user;
        $this->password = $password;
    }

    public function insert($tableName, $data)
    {
        $fields = array_keys($data);
        $values = array_map(function($value) {
            return "'" . $value . "'";
        }, array_values($data));

        $statement = sprintf(
            'INSERT INTO %s (%s) VALUES (%s)',
            $tableName,
            implode(', ', $fields),
            implode(', ', $values)
        );

        $this->query($statement);

        $lastInsertIdResult = $this->query('SELECT LAST_INSERT_ID()')->fetch_all();

        return $lastInsertIdResult[0][0];
    }

    public function query($statement)
    {
        if (null === $this->connection) {
            $this->connect();
        }

        $result = $this->connection->query($statement);

        if (false === $result) {
            throw new \RuntimeException(sprintf('Error executing query: [%s] [%s]', $statement, $this->connection->error));
        }

        return $result;
    }

    private function connect()
    {
        if (null !== $this->connection) {
            return;
        }

        $this->connection = new \mysqli($this->host, $this->user, $this->password, $this->dbName);

        if (!$this->connection) {
            throw new \RuntimeException('Connection error!');
        }
    }
}