<?php
/**
 * Created by PhpStorm.
 * User: Vitalik
 * Date: 05.08.2017
 * Time: 11:37
 */

namespace Framework;

use ArrayAccess;

/**
 * Class Registry is used to keep in single instance all app settings
 * @package Framework
 */
class Registry implements ArrayAccess
{
    /**array of application settings
     * @var mixed[]
     */
    private $registry = array();
    /**application instance
     * @var null
     */
    private static $instance = null;

    /**check whether class already has instances
     * if has, returns existed instance, otherwise create new one and returns it
     * @return Registry|null
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new Registry();
        }
        return self::$instance;
    }

    /**set registry value by key
     * @param  string $key
     * @param  mixed $value
     */
    public function set($key, $value)
    {
        if (isset($this->registry[$key])) {
            throw new Exception("There is already an entry for key " . $key);
        }
        $this->registry[$key] = $value;
    }

    /**get registry value by key
     * @param string $key
     * @return mixed registry value
     */
    public function get($key)
    {
        if (!isset($this->registry[$key])) {
            throw new Exception("There is no entry for key " . $key);
        }
        return $this->registry[$key];
    }

    //keep class single instance
    /**
     * Registry constructor.
     */
    private function __construct()
    {

    }

    /**
     *
     */
    private function __clone()
    {
    }


    /**arrayAccess method for access to array as to object properties and array elements simultaneously
     * @param mixed $offset
     * @return bool
     */
    function offsetExists($offset)
    {

        return isset($this->vars[$offset]);

    }


    /**arrayAccess method for access to array as to object properties and array elements simultaneously
     * @param mixed $offset
     * @return mixed
     */
    function offsetGet($offset)
    {

        return $this->get($offset);

    }


    /**arrayAccess method for access to array as to object properties and array elements simultaneously
     * @param mixed $offset
     * @param mixed $value
     */
    function offsetSet($offset, $value)
    {

        $this->set($offset, $value);

    }


    /**arrayAccess method for access to array as to object properties and array elements simultaneously
     * @param mixed $offset
     */
    function offsetUnset($offset)
    {

        unset($this->vars[$offset]);

    }

}