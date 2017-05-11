<?php

namespace core;

class Silver
{

    public $model;
    public $assign;

    public static $classMap=array();

    public static function run()
    {

        $route=new Route();
        //拼装字符串：\app\control\indexControl
        $controlClass=CONTROL.$route->control.'Control';
        $action=$route->action;
      
        $control=new $controlClass();
        $control->$action();
    }

    
    public static function load($class)
    {
        p('LOAD:'.SILVER . $class . '.php');
        if (isset($classMap[$class])) {
            return true;
        } else {
            if (is_file(SILVER . $class . '.php')) {
                include SILVER . $class . '.php';
                self::$classMap[$class]=$class;
            } else {
                return false;
            }
        }
    }
}
