<?php
/**
 * Created by PhpStorm.
 * User: Vitalik
 * Date: 13.08.2017
 * Time: 22:53
 */

namespace Framework;


/**
 * Class Flash is used to provide application messages to client interface as result
 * of user's actions
 * @package Framework
 */
class Flash
{
    /**
     * bootstrap alert blocks classes to display proper message type
     */
    const FLASH_SUCCESS = 'success';
    const FLASH_INFO = 'info';
    const FLASH_WARNING = 'warning';
    const FLASH_DANGER = 'danger';

    /** class name for bootstrap alert block
     * @var string
     */
    public $class;
    /**message to be transmitted
     * @var string
     */
    public $message;

    /** create new flash with given class and message
     * Flash constructor.
     */
    public function __construct($class = self::FLASH_SUCCESS, $message = '')
    {
        $this->class = $class;
        $this->message = $message;
    }


}