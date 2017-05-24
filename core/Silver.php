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
       
        $controlClass=$route->control;
        $action=$route->action;

        $control=new $controlClass();
        $requestPara= array();
        if($_SERVER['REQUEST_METHOD'] == "GET") {
            $requestPara=$_GET;
        }
        else if($_SERVER['REQUEST_METHOD']=="POST"){
            $requestPara=$_POST;
        }
        $control->$action($requestPara);
    }

    
    public static function load($class)
    {
        //TODO:p('LOAD:'.SILVER . $class . '.php');
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
