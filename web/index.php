<?php
require_once(__DIR__.'/../framework/Autoloader.php');
$loader = new \Framework\Autoloader();
// register the autoloader
$loader->register();
// register the base directories for the namespace prefix
$loader->addNamespace('Framework', __DIR__ . '/../framework');
$loader->addNamespace('Src', __DIR__ . '/../src');
$app = new \Framework\Application(__DIR__.'/../app/config/config.php');
$app->run();