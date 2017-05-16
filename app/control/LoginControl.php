<?php

namespace app\control;

use app\model\UserModel;

class LoginControl extends \core\Control
{


    public function login($para)
    { 
        $userModel=new UserModel();
            $res=$userModel->select('user', ['name','mail','password'],
                ['name'=>$para['name'],'password'=>$para['password']]);
        if(count($res)>0){
             $this->display('index.html');
        }else {
            $this->display('login.html');
        }
        
    }
}
