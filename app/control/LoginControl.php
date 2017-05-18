<?php

namespace app\control;

use app\model\UserModel;

class LoginControl extends \core\Control {


    public function login($para)
    { 
        if (empty($para)) {
            $this->display('login.html');
        } else {
            $res=$this->checkUser($para['name'],$para['password']);
            if ($res) {
                $this->display('index.html');
                //header('Location: http://www.baidu.com/');
                $_SESSION['userid']

            } else {
                $this->display('login.html');
            }
        }
    }

    function checkUser($name,$password){
          $userModel = new UserModel();
         $res = $userModel ->select('user', ['name', 'mail', 'password'],
                ['name'=>$name, 'password'=>$password]);

         return count($res)>0;
    }
}
