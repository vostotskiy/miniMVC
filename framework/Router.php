<?php


namespace Framework;

use Framework\Registry;
use Framework\Route;

/** Main routing class, responsible for url parsing and creating controller's instance
 * Class Router
 * @package Framework
 */
class Router
{

    /** registry instance for app configs access
     * @var Registry
     */
    protected $registry;
    /** list of routes, that is used to call proper controller according to accepted url pattern
     * @var Route[] routes
     */
    protected $routes;
    /** default route for 404 error redirect
     * @var \Framework\Route
     */
    protected $page_not_found_route;
    /** parsed from url params
     * @var array
     */
    protected $params;
    /**current module
     * @var string
     */
    protected $module;

    /** get current module name
     * @return string module name for current route
     */
    public function getModule()
    {
        return $this->module;
    }

    /** get current controller
     * @return string controller name for current route
     */
    public function getController()
    {
        return $this->controller;
    }

    /** get current action
     * @return string action name for current route
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @var BaseController  controller
     */
    protected $controller;
    /**current action
     * @var
     */
    protected $action;


    /**
     * Router constructor.
     * @param $routes
     * @param $page_not_found_route
     * @param $registry
     */
    public function __construct($routes, $page_not_found_route, $registry)
    {
        $this->registry = $registry;

        $this->page_not_found_route = new Route($page_not_found_route);
        foreach ($routes as $route) {
            $this->routes[] = new Route($route);
        }

    }

    /** compares current url with route's patterns
     * @param $pattern
     * @param $url
     * @return int
     */
    public function isMatchesPattern($pattern, $url)
    {
        $pattern = preg_replace('/\//', '\\/', $pattern);
        // Convert variables with custom regular expressions e.g. {id:\d+}
        $pattern = preg_replace('/\{([a-z]+):([^\}]+)\}/', '\2', $pattern);
        //\{:([a-z]+):([^\}]+)\}
        // Add start and end delimiters, and case insensitive flag
        $pattern = '/^' . $pattern . '$/i';
        return preg_match($pattern, $url);

    }

    /**parse params from request url with route's pattern
     * @param $pattern route pattern
     * @param $url request url
     * @return array  request params
     */
    public function parseParams($pattern, $url)
    {
        $params = [];
        $paramsReg = '/{([a-z]+):/i';
        preg_match_all($paramsReg, $pattern, $paramNames, PREG_OFFSET_CAPTURE, 0);
        $valuesReg = preg_replace('/\//', '\\/', $pattern);
        $valuesReg = preg_replace('/\{([a-z]+):([^\}]+)\}/', '(\2)', $valuesReg);
        $valuesReg = '/^' . $valuesReg . '$/i';
        preg_match_all($valuesReg, $url, $paramValues);
        unset($paramValues[0]);
        $paramNames = $paramNames[1];
        $i = 1;
        foreach ($paramNames as $name) {

            $params[$name[0]] = $paramValues[$i++][0];

        }
        return $params;


    }


    /**main method, that takes response url, searches proper route ,creates controller
     * instance and calls it's action with request params
     * @param $url
     */
    public function dispatch($url)
    {
        $url = trim($url, '/');
        //$url = filter_var($url, FILTER_SANITIZE_URL);
        $url = '/' . $url;
        $cur_route = null;
        foreach ($this->routes as $route) {
            if ($this->isMatchesPattern($route->pattern, $url)) {
                $cur_route = $route;
            }

        }
        if (is_null($cur_route)) {
            $cur_route = $this->page_not_found_route;

        }
        $this->params = $this->parseParams($cur_route->pattern, $url);
        $this->applyRoute($cur_route);

    }


    /** calls proper method and creates  given route's controller
     * @param $route
     * @throws \Exception
     */
    public function applyRoute($route)
    {
        $this->controller = ucfirst($route->controller);
        $this->module = ucfirst($route->module);
        $this->action = ucfirst($route->action) . "Action";
        $className = '\\' . $this->module . '\controllers\\' . $this->controller . "Controller";
        // Check if controller exists
        if (class_exists($className)) {
            $controller = new $className($this->registry);
            if (method_exists($controller, $this->action)) {
                if (!empty($this->params)) {
                    // Call the method and pass arguments to it
                    call_user_func_array(array($controller, $this->action), $this->params);
                } else {
                    $controller->{$this->action}();
                }
            } else {
                throw new \Exception("Route configuration error");
            }


        } else {
            throw new \Exception("class $className not found");
        }
    }


}