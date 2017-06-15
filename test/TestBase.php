<?php

define('ROOTPATH',realpath(dirname(__FILE__).'/../').'/');
require '..\vendor\autoload.php';
require '..\core\Function.php';
spl_autoload_register('load');
function load($class)
{
    if (is_file(ROOTPATH . $class . '.php')) {
        //p('LOAD:'.SILVER . $class . '.php');
        include ROOTPATH . $class . '.php';
    }
}
