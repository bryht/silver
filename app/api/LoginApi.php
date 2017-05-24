<?php

namespace app\api;

/**
 * LoginApi
 */
class LoginApi extends \core\Api
{

    public function login($para)
    {
        if (empty($para)) {
            $this->error('please post the login paras');
        } else {

            $res = \app\model\UserModel::instance()->checkUser($para['name'], $para['password']);
            if ($res != false) {
                
                
                
                $res['code'] = session_id();
                unset($res['password']);
                $this->success($res);

            } else {
                $this->error('login failed');
            }
        }
    }

    public function logout($para)
    {
        
        $this->success('logout success!');
    }
}
