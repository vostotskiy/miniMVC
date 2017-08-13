<?php
/**
 * Created by PhpStorm.
 * User: Vitalik
 * Date: 13.08.2017
 * Time: 22:53
 */

namespace Framework;


class Flash
{
    const FLASH_SUCCESS = 'success';
    const FLASH_INFO = 'info';
    const FLASH_WARNING = 'warning';
    const FLASH_DANGER = 'danger';

    public $class;
    public $message;

    /**
     * Flash constructor.
     */
    public function __construct($class = self::FLASH_SUCCESS, $message = '')
    {
        $this->class = $class;
        $this->message = $message;
    }


}