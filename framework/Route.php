<?php
/**
 * Created by PhpStorm.
 * User: Vitalik
 * Date: 06.08.2017
 * Time: 11:08
 */

namespace Framework;


class Route
{
    public $module;
    public $controller;
    public $pattern;
    public $action;


    /**
     * @return string
     */
    public function getModule()
    {
        return $this->module;
    }

    /**
     * @param mixed string
     */
    public function setModule($module)
    {
        $this->module = $module;
    }

    /**
     * @return string
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * @param string $controller
     */
    public function setController($controller)
    {
        $this->controller = $controller;
    }

    /**
     * @return string
     */
    public function getPattern()
    {
        return $this->pattern;
    }

    /**
     * @param string $pattern
     */
    public function setPattern($pattern)
    {
        $this->pattern = $pattern;
    }

    /**
     * @return string
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @param string $action
     */
    public function setAction($action)
    {
        $this->action = $action;
    }

    public function __construct($config)
    {
        $fields = ['pattern', 'module', 'controller', 'action'];
        foreach ($fields as $field) {
            $this->{$field} = $config[$field];
        }


    }


}