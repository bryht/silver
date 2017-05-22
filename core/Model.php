<?php

namespace core;

class Model extends \Medoo\Medoo
{
    protected static $_instance = null;
    public static function instance()
    {
        if (is_null(static::$_instance) || isset(static::$_instance)) {
            static::$_instance = new static();//only for php>5.3
        }
        return static::$_instance;
    }

    public function __construct()
    {
        $database = Conf::get_database();
        parent::__construct($database);
    }
}
