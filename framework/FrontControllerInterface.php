<?php

namespace Framework;


/**
 * Interface FrontControllerInterface is used to describe basic FrontController properties
 * @package Framework
 */
interface FrontControllerInterface
{
    /** init main settings method
     * @return mixed
     */
    public function bootstrap();

    /**run application by  creating and launching Router instance
     * @return mixed
     */
    public function run();
}