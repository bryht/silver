<?php

namespace app\Control;

use app\model\UserModel;

class LoginControl extends \core\Control
{
    public function __construct($foo = null)
    {

    }

    public function register($para)
    {
        if (empty($para)) {
            $this->assign('message', '');
            $this->display('register.html');
        } else {
            $check = UserModel::instance()->checkRegister($para['name'], $para['mail']);
            if ($check == true) {
                $this->assign('message', 'User or Mail alerady exist!');
                $this->display('register.html');
                return;
            }

            $res = UserModel::instance()->insertObj($para);
            if ($res > 0) {
                $this->assign('message', 'Register success!');
                $this->display('register.html');
            }
        }
    }

    public function forgetPassword($value = '')
    {
        $this->display('user-forget-password.html');
    }

    public function getPasswordBack($value = '')
    {
       $mail=$value['mail'];
       
    }

    public function login($para)
    {
        if (empty($para)) {
            $this->display('login.html');
        } else {

            $res = UserModel::instance()->checkUser($para['email'], $para['password']);
            if ($res != false) {
                session_set('user_id', $res['id']);
                session_set('user_name', $res['name']);
                session_set('user_auth', $res['auth']);
                //Notice: get the default album for the login user.
                $albumRes = \app\model\AlbumModel::instance()->getAlbumsByUserId($res['id']);
                if (count($albumRes) > 0) {
                    $albumId = $albumRes[0]['id'];
                } else {
                    $albumId = -1;
                }
                $this->redirect('index', 'index', ['album_id' => $albumId]); //default is main category
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
