<?php

namespace app\control;

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
            $res = $this->checkUser($para['name'], $para['password']);
            if ($res != false) {
                session_set('user_id', $res['id']);
                session_set('user_name', $res['name']);
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

    public function checkUser($name, $password)
    {
        $userModel = new UserModel();
        $res = $userModel->select('user',
            ['id', 'name', 'mail', 'password'],
            ['name' => $name, 'password' => $password]);
        if (count($res) > 0) {
            return $res[0];
        } else {
            return false;
        }
    }
}
