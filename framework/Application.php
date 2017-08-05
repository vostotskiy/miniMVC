<?php
/**

 */

namespace Framework;

class Application implements FrontControllerInterface
{
    /**
     * @var array|mixed
     */
    protected $config       = array();


    /**
     * Application constructor.
     * @param string $configPath path to ap config file
     * @throws \Exception
     */
    public function __construct($configPath = '') {
        if(!is_file($configPath)){
            throw new \Exception('Config file not found');
        }
        $this->config = include($configPath);
    }

    /**
     * Init app environment, like DB instance
     */
    public function bootstrap(){



    }


    /**
     *
     */
    public function run() {

    }

}