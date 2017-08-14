<?php

namespace Framework;


/**
 * Class Route is used to describe route domain
 * @package Framework
 */
class Route
{
    /** module's name
     * @var string
     */
    public $module;
    /** controller's name
     * @var string
     */
    public $controller;
    /** regular expression to check current route
     * @var string
     */
    public $pattern;
    /** action's name
     * @var string
     */
    public $action;


    /** get module name
     * @return string
     */
    public function getModule()
    {
        return $this->module;
    }

    /** set module name
     * @param mixed string
     */
    public function setModule($module)
    {
        $this->module = $module;
    }

    /** get controller name
     * @return string
     */
    public function getController()
    {
        return $this->controller;
    }

    /** set controller name
     * @param string $controller
     */
    public function setController($controller)
    {
        $this->controller = $controller;
    }

    /** get route pattern
     * @return string
     */
    public function getPattern()
    {
        return $this->pattern;
    }

    /**set route pattern
     * @param string $pattern
     */
    public function setPattern($pattern)
    {
        $this->pattern = $pattern;
    }

    /**get action
     * @return string
     */
    public function getAction()
    {
        return $this->action;
    }

    /**set action
     * @param string $action
     */
    public function setAction($action)
    {
        $this->action = $action;
    }

    /**
     * Route constructor.
     * @param $config
     */
    public function __construct($config)
    {
        $fields = ['pattern', 'module', 'controller', 'action'];
        foreach ($fields as $field) {
            $this->{$field} = $config[$field];
        }


    }


}