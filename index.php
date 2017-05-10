<?php


define('SILVER',realpath(__DIR__).'/');
define('CORE',SILVER.'core\\');
define('APP','\app\\');
define('CONTROL',APP.'control\\');
define('VIEW',APP.'view\\');
define('DEBUG',true);

if (DEBUG) {
    ini_set('display_error','On');
}else {
    ini_set('display_error','Off');
}

include CORE.'\function.php';
include CORE.'\silver.php';
spl_autoload_register('core\silver::load');

core\silver::run();
