<?php


namespace Framework;
use PDO;
use Framework\Registry;
use Framework\Router;
use Framework\Request;

/**
 * Class Application is aimed to keep all MVC parts together
 * @package Framework
 */
class Application implements FrontControllerInterface
{

 /*
  * @var Framework\Registry $registry
  * Registry object to keep applications services and settings instances
  */
    /**
     * @var \Framework\Registry
     */
    protected  $registry;
    /**
     * array of application configurations
     * @var array|mixed
     */
    protected $config     = array();


    /**
     * Application constructor.
     * @param string $configPath path to ap config file
     * @throws \Exception
     */
    public function __construct(Registry $registry,$configPath = '') {
        if(!is_file($configPath)){
            throw new \Exception('Config file not found');
        }
        $this->config = include($configPath);
        $this->registry = $registry;
        $this->registry->set('show_errors',$this->config['show_errors']);
        $this->registry->set('log_errors',$this->config['log_errors']);

    }

    /**
     * Init app environment, create main services instances
     */
    public function bootstrap(){

    $dbData =  $this->config['db'];
    $db = new PDO("mysql:host={$dbData['host']};dbname={$dbData['db']}", $dbData['user'], $dbData['password']);
    $this->registry->set ('db', $db);
    $this->registry['request'] = new Request();
    return $this;
    }



    public function run() {
        $router = new Router($this->config['routes'],$this->config['page_not_found_route'],$this->registry);
        $this->registry['router'] = $router;
        $router->dispatch($this->registry['request']->getUrl());




    }

}