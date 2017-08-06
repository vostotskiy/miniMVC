<?php

namespace Framework;


Abstract class BaseController
{

    protected $registry;
    protected $template;
    protected $layouts;

    public $vars = array();


    function __construct($registry) {
        $this->registry = $registry;
      //  $this->template = new Template($this->layouts, get_class($this));
    }

    abstract function indexAction();

}