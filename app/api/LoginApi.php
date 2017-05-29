<?php

namespace app\api;

/**
 * LoginApi
 */
class LoginApi extends \core\Control
{

    public function login($para)
    {
        if (empty($para)) {
            $this->error('please post the login paras');
        } else {

            $res = \app\model\UserModel::instance()->checkUser($para['name'], $para['password']);
            if ($res != false) {
                $resReturn['code'] = \md5($res['id'] + $res['name']);
                $resReturn['expired'] = date('U');
                $resReturn['id'] = $res['id'];
                $resReturn['name'] = $res['name'];
                \core\Cache::instance()->save($resReturn['code'], $resReturn); //TOOD: add expire date control
                $this->success($resReturn);
            } else {
                $this->error('login failed');
            }
        }
    }

    public function logout($para)
    {
       \core\Cache::instance()->delete($para['code']);
        $this->success('logout success!');
    }
}
