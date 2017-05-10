<?php

namespace app\control;

class indexControl extends \core\control{


    public function index(){
       
       $model=new \core\model();
       p($model);
       $sql="SELECT * FROM `vote_userdata`";
       $ret=$model->query($sql);
       p($ret->fetchAll());
    }


    public function page(){

        $this->assign('data','Hello');
        $this->display('index.html');
    }
 
}