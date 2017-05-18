<?php

namespace app\control;

use app\model\UserModel;

class LoginControl extends \core\Control
{

    public function login($para)
    {
        if (empty($para)) {
            $this->display('login.html');
        } else {
            $res = $this->checkUser($para['name'], $para['password']);
            if ($res>0) {
                 
                session_start();
                $_SESSION['userid']=$res;
                //TODO:跳转
               
            } else {
                $this->display('login.html');
            }
        }
    }

    public function logout(){
        unset($_SESSION['userid']);
    }

    public function checkUser($name, $password)
    {
        $userModel = new UserModel();
        $res = $userModel->select('user', ['id','name', 'mail', 'password'],
            ['name' => $name, 'password' => $password]);
        if(count($res)>0){
            return $res[0]['id'];
        }else {
            return -1;
        }
    }
}
