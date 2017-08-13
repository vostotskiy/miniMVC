<?php
/**
 * Created by PhpStorm.
 * User: Vitalik
 * Date: 07.08.2017
 * Time: 19:58
 */

namespace Framework;

use Framework\Registry;
use PDO;



abstract class ActiveRecord
{
    /**
     * The attributes that belongs to the table
     * @var  Array
     */
    protected $attributes = array();
    /**
     * Table name
     * @var  String
     */
    protected $table_name;
    /**
     * Username
     * @var String
     */

    /**
     * Connection instance
     * @var  String
     */
    protected $connection;
    /**
     * The database name
     * @var  String
     */

    protected $id_name = 'id';

    protected $_query;

    function __construct() {
        $registry = Registry::getInstance();
        $this->connection = $registry['db'];
    }

    public  function toArray(){
        return $this->attributes ? $this->attributes : null;
    }
    public function fill($attributes){
        $this->attributes = $attributes;
        return $this;
    }

    public function getAttributes()
    {
        return $this->attributes;
    }

    public function getAttribute($key)
    {
        return isset($this->attributes[$key]) ? $this->attributes[$key] : null;
    }

    public function setAttribute($key, $value)
    {
        $this->attributes[$key] = $value;
    }

    public function __get($key)
    {
        if (array_key_exists($key, $this->attributes))
        {
            return $this->getAttribute($key);
        }

        return null;
    }

    public function __set($key, $value)
    {
        $this->setAttribute($key, $value);
    }

    public function __isset($key)
    {
        return array_key_exists($key, $this->attributes);
    }

    /**
     * Find a row given the id
     *
     * @param $id
     * @return null|Mixed
     */
    public function findById($id)
    {
        $conn = $this->getConnection();
        $this->_query = $conn->query("SELECT * FROM {$this->table_name} WHERE  {$this->id_name}= " . $conn->quote($id));

        $obj = $this->_query->fetch(PDO::FETCH_ASSOC);

        return ($obj) ? $this->newInstance($obj) : null;
    }

    public function findAll(){
        $conn = $this->getConnection();
        $this->_query = $conn->query("SELECT * FROM {$this->table_name}");
        $objs = $this->_query->fetchAll(PDO::FETCH_ASSOC);
        // the model instantiated
        $models = array();

        if(! empty($objs))
        {
            foreach($objs as $obj)
            {
                $models[] = $this->newInstance($obj);
            }
        }

        return $models;
    }


    /**
     * Find rows given a where condition
     *
     * @param $where_cond
     * @return null|PDOStatement
     */
    public function where($where_cond)
    {
        $conn = $this->getConnection();
        $query = $conn->query("SELECT * FROM {$this->table_name} WHERE {$where_cond}");
        $objs = $query->fetchAll(PDO::FETCH_ASSOC);
        // the model instantiated
        $models = array();

        if(! empty($objs))
        {
            foreach($objs as $obj)
            {
                $models[] = $this->newInstance($obj);
            }
        }

        return $models;
    }

    public function newInstance(array $data)
    {
        $class_name = get_class($this);
        $newClass = new $class_name();
        $newClass->fill($data);
        return $newClass;
    }

    /**
     * Save the model
     * @return bool
     */
    public function save()
    {
        try
        {
            if(array_key_exists($this->id_name, $this->attributes))
            {
                $attributes = $this->attributes;
                unset($attributes[$this->id_name]);
                $this->update($attributes);
            }
            else
            {
                $id = $this->insert($this->attributes);
                $this->setAttribute($this->id_name, $id);
            }
        }
        catch(ErrorException $e)
        {
            return false;
        }

        return true;
    }

    /**
     * Used to prepare the PDO statement
     *
     * @param $connection
     * @param $values
     * @param $type
     * @return mixed
     * @throws InvalidArgumentException
     */
    protected function prepareStatement($connection, $values, $type)
    {
        if($type == "insert")
        {
            $sql = "INSERT INTO {$this->table_name} (";
            foreach ($values as $key => $value) {
                $sql.="{$key}";
                if($value != end($values) )
                    $sql.=",";
            }
            $sql.=") VALUES(";
            foreach ($values as $key => $value) {
                $sql.=":{$key}";
                if($value != end($values) )
                    $sql.=",";
            }
            $sql.=")";
        }
        elseif($type == "update")
        {
            $sql = "UPDATE {$this->table_name} SET ";
            foreach ($values as $key => $value) {
                $sql.="{$key} =:{$key}";
                if($value != end($values))
                    $sql.=",";
            }
            $sql.=" WHERE {$this->id_name}=:{$this->id_name}";
        }
        else
        {
            throw new InvalidArgumentException("PrepareStatement need to be insert,update or delete");
        }

        return $connection->prepare($sql);
    }

    /**
     * Used to insert a new record
     * @param array $values
     * @throws ErrorException
     */
    public function insert(array $values)
    {
        $connection = $this->getConnection();
        $statement = $this->prepareStatement($connection, $values, "insert");
        foreach($values as $key => $value)
        {
            $statement->bindValue(":{$key}", $value);
        }

        $success = $statement->execute($values);
        if(! $success)
            throw new ErrorException;

        return $connection->lastInsertId();
    }

    /**
     * Update the current row with new values
     *
     * @param array $values
     * @return bool
     * @throws ErrorException
     * @throws BadMethodCallException
     */
    public function update(array $values)
    {
        if( ! isset($this->attributes[$this->id_name]))
            throw new BadMethodCallException("Cannot call update on an object non already fetched");

        $connection = $this->getConnection();
        $statement = $this->prepareStatement($connection, $values, "update");
        foreach($values as $key => $value)
        {
            $statement->bindValue(":{$key}", $value);
        }
        $statement->bindValue(":{$this->id_name}", $this->attributes[$this->id_name]);
        $success = $statement->execute();

        // update the current values
        foreach($values as $key => $value)
        {
            $this->setAttribute($key, $value);
        }

        if(! $success)
            throw new ErrorException;

        return true;
    }

    /**
     * Deletes the current row if exists
     */
    public function delete(){
        if( ! isset($this->attributes[$this->id_name]))
            throw new BadMethodCallException("Cannot call delete on an object non already fetched");

        $connection = $this->getConnection();

        $statement = $connection->prepare("DELETE FROM {$this->table_name} WHERE {$this->id_name} = :id");
        $statement->bindParam(':id', $this->attributes[$this->id_name]);

        return $statement->execute();
    }

    /**
     * Get the connection to the database
     *
     * @throws  PDOException
     */
    protected function getConnection()
    {
        return $this->connection;

    }
}