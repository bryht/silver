<?php

namespace app\Control;

use core\model;

class IndexControl extends \core\Control
{

    public function index()
    {
        $model=new Model();
        $datas = $model->select("images", "title");
        p($datas);
        $this->assign('data', 'Hello');
        $this->display('index.html');
    }


    public function page()
    {
        $this->assign('data', 'Hello');
        $this->display('index.html');
    }
}
