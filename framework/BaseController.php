<?php

namespace Framework;
use Framework\Response;
use Framework\Request;
use Framework\View;
use Framework\Model;
use Framework\Flash;

/**
 * Class BaseController
 * @package Framework
 */
Abstract class BaseController
{

    /**
     * @var Registry|null registry object for settings access
     */
    protected $registry;
    /**
     * @var Response|null Response instance
     */
    public $response;
    /**
     * @var View|null View instance
     */
    protected $view;

    /**
     * @var Request|null request service instance
     */
    public $request;
    /**
     * @var Model|null Model instance
     */
    public $model;


    function __construct() {
        $this->registry = Registry::getInstance();
        $this->request = $this->registry['request'];

    }

    /**
     * default action of controller, thar must be implemented in Controller classes
     */
    abstract function indexAction();

    /**
     * render View rendertemplate wrapper for easy call from controller
     * @param string $viewName relative name of view(starting from views folder)
     * @param array $params template variables
     */
    public function render($viewName, $params)
    {
        $router = $this->registry['router'];
        $this->view = new View($router->getModule(), $router->getController(), $params);
        $renderData = $this->view->renderTemplate($viewName);
        $this->response = new Response(200, [], $renderData);
        $this->response->send();

    }

    /**
     * Redirect application to given $url path
     *
     * @param string $url URL to redirecting
     */
    public function redirect($url)
    {
        Response::redirect($url);

    }

    public function setFlash($class, $message)
    {
        if ((!strlen($class)) && (!strlen($message))) {
            return false;
        }
        $this->registry->flashes[] = new Flash($class,$message);
    }



}