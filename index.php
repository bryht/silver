<?php

define('SILVER', realpath(__DIR__) . '/');
define('APP', '\app\\');
define('API', APP . 'api\\');
define('CONTROL', APP . 'control\\');
define('VIEW', APP . 'view\\');
define('CACHE', '\cache\\');
define('LOG', CACHE . 'log\\');
define('CORE', '\core\\');
define('UPLOAD', '\upload\\');
define('VENDOR', '\vendor\\');
define('DEBUG', true);

require CORE . '\Function.php';
require CORE . '\Silver.php';
require VENDOR . '\autoload.php';

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
