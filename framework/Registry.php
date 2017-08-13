<?php
/**
 * Created by PhpStorm.
 * User: Vitalik
 * Date: 05.08.2017
 * Time: 11:37
 */

namespace Framework;

use ArrayAccess;

class Registry implements ArrayAccess
{
    private $registry = array();
    private static $instance = null;

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new Registry();
        }
        return self::$instance;
    }

    public function set($key, $value)
    {
        if (isset($this->registry[$key])) {
            throw new Exception("There is already an entry for key " . $key);
        }
        $this->registry[$key] = $value;
    }

    public function get($key)
    {
        if (!isset($this->registry[$key])) {
            throw new Exception("There is no entry for key " . $key);
        }
        return $this->registry[$key];
    }

    //keep class single instance
    private function __construct()
    {

    }

    private function __clone()
    {
    }


    function offsetExists($offset)
    {

        return isset($this->vars[$offset]);

    }


    function offsetGet($offset)
    {

        return $this->get($offset);

    }


    function offsetSet($offset, $value)
    {

        $this->set($offset, $value);

    }


    function offsetUnset($offset)
    {

        unset($this->vars[$offset]);

    }

}