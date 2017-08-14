<?php
use Framework\Application;
use Framework\Registry;
use Framework\Error;
require_once(__DIR__.'/../framework/Autoloader.php');
$loader = new \Framework\Autoloader();
// register the autoloader
$loader->register();
// register the base directories for the namespace prefix
$loader->addNamespace('Framework', __DIR__ . '/../framework');
$loader->addNamespace('Students', __DIR__ . '/../src/Students');
$loader->addNamespace('Common', __DIR__ . '/../src/Common');
$loader->addNamespace('Src', __DIR__ . '/../src');
/**
 * Error and Exception handling
 */
error_reporting(E_ALL);
set_error_handler('Framework\Error::errorHandler');
set_exception_handler('Framework\Error::exceptionHandler');

$app = new \Framework\Application(Registry::getInstance(),__DIR__.'/../app/config.php');
$app->bootstrap()->run();


function _d($data, $isDie = 1)
{
    echo '<pre>';
    print_r($data);
    echo '</pre>';
    if($isDie){
        die;
    }
}