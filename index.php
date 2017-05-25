<?php


define('SILVER', realpath(__DIR__).'/');
define('CORE', SILVER.'core\\');
define('APP', '\app\\');
define('CACHE',APP.'cache\\');
define('CONTROL', APP.'control\\');
define('API', APP.'api\\');
define('VIEW', APP.'view\\');
define('UPLOAD', 'upload\\');
define('DEBUG', true);

require CORE.'\Function.php';
require CORE.'\Silver.php';
require SILVER."vendor/autoload.php";
spl_autoload_register('core\Silver::load');

if (DEBUG) {
    $whoops = new \Whoops\Run;
    $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
    $whoops->register();
    ini_set('display_error', 'On');
} else {
    ini_set('display_error', 'Off');
}
core\Silver::run();
