<?php


namespace Framework;

use Framework\Registry;
use Framework\Route;

class Router
{

    protected $registry;
    protected $routes;
    protected $default_route;
    protected $params;
    protected $module;
    protected $controller;
    protected $action;



   public function __construct($routes,$default_route,$registry){
       $this->registry = $registry;

       $this->default_route = new Route($default_route);
       foreach ($routes as $route){
           $this->routes[] = new Route($route);
       }

   }

   public function isMatchesPattern($pattern,$url){
       $pattern = preg_replace('/\//', '\\/', $pattern);
       // Convert variables with custom regular expressions e.g. {id:\d+}
       $pattern = preg_replace('/\{([a-z]+):([^\}]+)\}/', '\2', $pattern);
       //\{:([a-z]+):([^\}]+)\}
       // Add start and end delimiters, and case insensitive flag
       $pattern = '/^' . $pattern . '$/i';
       return preg_match($pattern,$url);

   }
   public function parseParams($pattern,$url){
       $params = [];
       $paramsReg = '/{([a-z]+):/i';
       preg_match_all($paramsReg, $pattern, $paramNames, PREG_OFFSET_CAPTURE, 0);
       $valuesReg = preg_replace('/\//', '\\/', $pattern);
       $valuesReg = preg_replace('/\{([a-z]+):([^\}]+)\}/', '(\2)', $valuesReg);
       $valuesReg = '/^' . $valuesReg . '$/i';
       preg_match_all($valuesReg,$url,$paramValues);
       unset($paramValues[0]);
       $paramNames = $paramNames[1];
       $i=1;
       foreach($paramNames as $name){

           $params[$name[0]] = $paramValues[$i++][0];

       }
       return $params;



   }





   public function dispatch($url){
       $url = trim($url, '/');
       //$url = filter_var($url, FILTER_SANITIZE_URL);
       $url = '/'.$url;
       $cur_route = null;
       foreach ($this->routes as $route){
           if($this->isMatchesPattern($route->pattern,$url)){
               $cur_route = $route;
           }

       }
       if(is_null($cur_route)){
           //@todo 404 error;
           die('no router found');
       }
       $this->params = $this->parseParams($cur_route->pattern,$url);
       $this->applyRoute($cur_route);
       //$a = new \Students\controllers\IndexController();
   }


    public function applyRoute($route)
    {
        $this->controller = ucfirst($route->controller) . "Controller";
        $this->module = ucfirst($route->module);
        $this->action = ucfirst($route->action) . "Action";
        $className = '\\' . $this->module . '\controllers\\' . $this->controller;
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
                //error -no action =>404
            }


        } else{
            //error -no controller =>404
        }
    }



}