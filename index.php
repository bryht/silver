<?php


define('SILVER',realpath(__DIR__));
define('CORE',SILVER.'/core/');
define('APP','/app/');
define('DEBUG',true);

if (DEBUG) {
    ini_set('display_error','On');
}else {
    ini_set('display_error','Off');
}

include CORE.'/common/function.php';
include CORE.'/silver.php';

core\silver::run();
