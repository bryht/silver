<?php

namespace app\Control;

use app\model\UserModel;

class LoginControl extends \core\Control
{
    public function __construct($foo = null)
    {

    }

    public function login($para)
    {
        if (empty($para)) {
            $this->display('login.html');
        } else {
           
            $res = UserModel::instance()->checkUser($para['name'], $para['password']);
            if ($res != false) {
                session_set('user_id', $res['id']);
                session_set('user_name', $res['name']);
                session_set('user_auth', $res['auth']);
                $this->redirect('index', 'index');
            } else {
                $this->display('login.html');
            }
        }
    }

    public function logout()
    {
        if (!session_id()) {
            session_start();
        }
        session_destroy();
        $this->redirect('login', 'login');
    }

   
}
