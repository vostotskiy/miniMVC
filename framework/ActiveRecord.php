<?php
/**
 * Created by PhpStorm.
 * User: Vitalik
 * Date: 07.08.2017
 * Time: 19:58
 */

namespace Framework;

use PDO;


class ActiveRecord {

    protected static $_defaultDBConnection;


    /**
     * @var $_fields array
     */
    protected $_fields = array();

    /**
     * Key field value for row which this object representing
     *
     * @var mixed
     */
    protected $_key = null;

    /**
     * Key field name in table, usually are primary
     *
     * @var string
     */
    protected $_keyField = null;

    /**
     * Database connection handler
     *
     * @var PDO
     */
    protected $_dbConnection = null;

    /**
     * Table name, where represented row contains
     *
     * @var string
     */
    protected $_tableName = null;

    /**
     * Constructor
     *
     * @param string $tableName
     * @param mixed $key [optional]
     * @param PDO $dbConnection [optional]
     * @return
     */
    public function __construct($tableName, $key=null, PDO $dbConnection=null){
        $this->_tableName = $tableName;
        $this->_key = $key;

        $this->_dbConnection = (!$dbConnection && self::$_defaultDBConnection)?
            self::$_defaultDBConnection:
            $dbConnection;

        $this->_dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    /**
     * Getter method for row's key
     *
     * @return mixed
     */
    public function getKey(){
        return $this->_key;
    }

    public function __get($field){
        return $this->getValue($field);
    }

    /**
     * This method return value for given row's field.
     * Also if data isn't avaliable - tried to download her from database (Lazy)
     *
     * @throws Exception
     * @param object $field
     * @return
     */
    public function getValue($field){
        if(!$this->_fields){
            $this->describe();
        }

        if(isset($this->_fields[$field])){
            if(!$this->_fields[$field]['value']){
                $this->select();
            }

            return $this->_fields[$field]['value'];
        } else {
            throw new Exception('Unknown field `'.$field.'`');
        }
    }

    public function __set($field, $value){
        return $this->setValue($field, $value);
    }

    /**
     * Setting value for row's field.
     * To commit changes use commit() method
     *
     * @throws Exception
     * @param object $field
     * @param object $value
     * @return
     */
    public function setValue($field, $value){
        if(!$this->_fields){
            $this->describe();
        }

        if(isset($this->_fields[$field])){
            $this->_fields[$field]['value'] = $value;
            $this->_fields[$field]['changed'] = true;

            return $this->_fields[$field]['value'];
        }else{
            throw new Exception('Unknown field `'.$field.'`');
        }
    }

    /**
     * Set DB connection handler, but only for this instance.
     *
     * @param PDO $db
     * @return PDO
     */
    public function setDBConnection(PDO $db){
        return $this->_dbConnection = $db;
    }

    /**
     * This method return DB connection method which used in this instance.
     *
     * @return PDO
     */
    public function getDBConnection(){
        return $this->_dbConnection;
    }

    /**
     * Set default DB connection handler.
     * Used by default by all ActiveRecord instances, if not specified
     *
     * @param PDO $db
     * @return PDO
     */
    public static function setDefaultDBConnection(PDO $db){
        return self::$_defaultDBConnection = $db;
    }

    /**
     * This method return default DB Connection handler
     *
     * @return PDO
     */
    public static function getDefaultDBConnection(){
        return self::$_defaultDBConnection;
    }

    /**
     * Commit changes to database
     * if key isn't specified trying to insert data to table, new row's id will remembered
     * else, if key specified - row with spicified key will updated, but only fields which changed
     *
     * @throws PDOException, Exception
     * @return
     */
    public function commit(){
        if(!$this->_fields){
            $this->describe();
        }

        if(!$this->_key){
            $this->_key = $this->insert();
        }else{
            $this->update();
        }

        $this->changeFields();
    }

    /**
     * Inserts data in table and return new row's key
     *
     * @return int
     */
    protected function insert(){
        if(!$this->_fields){
            $this->describe();
        }

        $fields = array();
        $values = array();

        foreach($this->_fields as $field=>$data){
            if($field == $this->_keyField && !$this->_key){ //we won't insert key field if we aren't really wont it, right?
                continue;
            }

            $rawValue = ":{$field}";
            if($rawExpression = $this->getDatabaseExpresion($data['value'])){
                $rawValue = $rawExpression;
            } else {
                $values[":{$field}"] = $this->formatValue($data['value'], $data['fieldType']);
            }

            $fields['left'] [$field] = "`{$field}`";
            $fields['right'][$field] = $rawValue;
        }

        $sql = "INSERT INTO `{$this->_tableName}` (".implode(', ', $fields['left']).') VALUES ('.implode(', ', $fields['right']).');';

        $db = $this->getCheckedDBConnection();
        $stmt = $db->prepare($sql);
        $stmt->execute($values);

        return $this->_key = $db->lastInsertId($this->_keyField);
    }

    protected function changeFields(){
        foreach($this->_fields as $field=>&$data){
            $data['changed'] = false;
        }
    }


    /**
     * Updates table's row data
     */
    protected function update(){
        if(!$this->_fields){
            $this->describe();
        }

        if(!$this->_key || !$this->_keyField){
            throw new Exception("Key field ('{$this->_key}', `{$this->_keyField}`) are invalid");
        }

        $set = array();
        $values = array();

        foreach($this->_fields as $field=>$data){
            if($field == $this->_keyField || !$data['changed']){ //we won't key field or unchanged field appears in set list, right?
                continue;
            }

            $rawValue = ":{$field}";
            if($rawExpression = $this->getDatabaseExpresion($data['value'])){
                $rawValue = $rawExpression;
            } else {
                $values[":{$field}"] = $this->formatValue($data['value'], $data['fieldType']);
            }

            $set[$field] = "`{$field}` = {$rawValue}";

        }

        $values[':PrimaryKey'] = $this->_key;

        if(!$set){ // nothing to update
            //throw new Exception('Nothing to update');
            return;
        }

        $sql = "UPDATE `{$this->_tableName}` SET ".implode(', ', $set)." WHERE `{$this->_keyField}` = :PrimaryKey";


        $stmt = $this->getCheckedDBConnection()->prepare($sql);
        $stmt->execute($values);
    }

    protected function select(){
        if(!$this->_fields){
            $this->describe();
        }

        if(!$this->_key || !$this->_keyField){
            throw new Exception("Key field ('{$this->_key}', `{$this->_keyField}`) are invalid");
        }

        $db = $this->getCheckedDBConnection();
        $sql = "SELECT * FROM `{$this->_tableName}` WHERE `{$this->_keyField}` = :key LIMIT 1";
        $stmt = $db->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute(array(':key'=>$this->_key));

        foreach($stmt->fetch() as $field=>$value){
            //field must present
            assert(isset($this->_fields[$field]));
            $this->_fields[$field]['changed'] = false;
            $this->_fields[$field]['value'] = $value;
        }

    }

    protected function describe(){
        if(!$this->_tableName){
            throw new Exception("Invalid table name");
        }

        $db = $this->getCheckedDBConnection();

        $sql = "DESCRIBE `{$this->_tableName}`;";
        $result = $db->query($sql, PDO::FETCH_ASSOC);

        if(!$result){
            $error = $db->errorInfo();
            throw new Exception("[$error[0]}: {$error[2]}", $error[1]);
        }

        $mysql_index = array('','PRI', 'MUL', 'UNI');

        $return = array();

        foreach($result->fetchAll() as $row){
            $field = array();
            $field['index'] = array_search($row['Key'], $mysql_index);


            //there can't be two primary indexes in one table
            assert(!($field['index'] === 1 && $this->_keyField));

            if($field['index'] === 1){
                $this->_keyField = $row['Field'];
            }


            $field['changed'] = false;
            $type = explode('(', $row['Type'], 2);

            $field['fieldType'] = strtolower($type[0]);
            if(isset($type[1])){
                $field['fieldLength'] = trim($type[1],')');
            }

            $return[$row['Field']] = $field;

        }

        return $this->_fields = $return;
    }

    /**
     *
     * @return PDO
     */
    protected function getCheckedDBConnection(){
        $db = $this->getDBConnection();
        if(!$db){
            $defaultDB = $this->getDefaultDBConnection();
            if(!$defaultDB){
                throw new Exception('No database connection');
            }

            $db = $this->setDBConnection($defaultDB);
        }

        return $db;
    }

    protected function getDatabaseExpresion($value){
        if(class_exists("Zend_Db_Expr") && $value instanceof Zend_Db_Expr){ // Zend Database expression support
            return (string)$value;
        }

        /** //It's unsafe to uncomment
        if($value[0] == '%'){
        return substr($value, 1);
        }
         **/

        return false;
    }

    protected function formatValue($value, $fieldType){
        $mysql_dateformats = array('datetime'=>'Y-m-d H:i:s', 'time'=>'H:i:s', 'date'=>'Y-m-d');

        if(isset($mysql_dateformats[$fieldType])){ // date
            $value = date($mysql_dateformats[$fieldType], is_numeric($value)?$value:strtotime($value));
        }

        if($data['indexType'] == 'int'){ //int
            $value = (int)$value;
        }

        return $value;
    }

}
