<?php


namespace core;

class Conf
{
    public static function get_database()
    {
        return array(
            'database_type' => 'mysql',
            'database_name' => 'gallery',
            'server' => 'localhost',
            'username' => 'root',
            'password' => 'liming',
            'charset' => 'utf8',
            'prefix' => 'silver_',
        );
    }

    public static function get_init_index()
    {
        return  array(
            'control' => 'index',
            'action'=>'index');
    }


}
