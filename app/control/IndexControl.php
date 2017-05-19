<?php

namespace app\Control;

use core\model;

class IndexControl extends \core\Control
{
    function __construct(){
        parent::__construct();
    }

    public function index()
    {
        $this->display('index.html');
    }

    public function add(){

        
        $this->display('index-add.html');
    }


    public function page()
    {
        $this->assign('data', 'Hello');
        $this->display('index.html');
    }
}
