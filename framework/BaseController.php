<?php

namespace Framework;
use Framework\Response;
use Framework\Request;
use Framework\View;
use Framework\Model;

Abstract class BaseController
{

    protected $registry;
    public $response;
    protected $layout;
    protected $view;

    public $request;
    public $model;



    function __construct() {
        $this->registry = Registry::getInstance();
        $this->request = $this->registry['request'];

      //  $this->template = new Template($this->layouts, get_class($this));
    }

    abstract function indexAction();

    public function render($viewName,$params){
        $router = $this->registry['router'];
        $this->view = new View($router->getModule(),$router->getController(),$params);
        $renderData =  $this->view->renderTemplate($viewName);
$this->response = new Response(200,[],$renderData);
$this->response->send();



    }


}