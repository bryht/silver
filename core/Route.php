<?php

namespace core;

class Route{

    public $control;
    public $action;

    public function __construct(){
        $request_uri=$_SERVER['REQUEST_URI'];
        if ($request_uri!='/') {
            $patharr=explode('/',$request_uri);
            $this->control=$patharr[1];
            $this->action=$patharr[2];
        }else{
            $conf=Conf::get_init_index();
            $this->control=$conf['control'];
            $this->action=$conf['action'];
        }

    }


}
