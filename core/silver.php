<?php

namespace core;

class silver{

    public $model;
    public $assign;

    public static $classMap=array();


    
    public static function run(){

       $route=new \core\route();

       
    }


    
    public static function load($class){

        if (isset($classMap[$class])) {
            return true;
        }else{
            $class=str_replace('\\','/',$class);
            if (is_file(SILVER . $class . '.php')) {
                include SILVER . $class . '.php';
                self::$classMap[$class]=$class;
            } 
            else{
                return false;
            }
        }
    }


}