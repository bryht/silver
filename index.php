<?php

define('SILVER', realpath(__DIR__) . '/');
define('CORE', SILVER . 'core\\');
define('APP', '\app\\');
define('CACHE', SILVER . 'cache\\');
define('LOG', CACHE . 'log\\');
define('CONTROL', APP . 'control\\');
define('API', APP . 'api\\');
define('VIEW', APP . 'view\\');
define('UPLOAD', 'upload\\');
define('DEBUG', true);

require CORE . '\Function.php';
require CORE . '\Silver.php';
require SILVER . "vendor\autoload.php";

spl_autoload_register('core\Silver::load');

if (DEBUG) {
    $whoops = new \Whoops\Run;
    $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
    $whoops->register();

} else {
    error_reporting(0);
    set_error_handler('errorHandler');
    register_shutdown_function('fatalErrorHandler');
}

core\Silver::run();
