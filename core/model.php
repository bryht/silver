<?php

namespace core;

class model extends \PDO{

    public function __construct(){
        $dsn='mysql:host=10.24.217.22;dbname=vote';
        $username='root';
        $password='liming';
       
        try{
            parent::__construct($dsn,$username,$password);
        }catch(\PDOException $e){
            p($e->getMessage());
        }
        
    }

}