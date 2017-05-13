<?php

namespace core;

class Model extends \Medoo\Medoo
{
    
    public function __construct()
    {
        $database=Conf::get_database();
        parent::__construct($database);
    }
}
