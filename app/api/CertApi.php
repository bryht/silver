<?php

namespace app\api;

/**
 * LoginApi
 */
class CertApi extends \core\Api
{

    public function __construct($foo = null)
    {
        if (session_get('user_id') == false) {

            $this->redirect('login', 'login');
        }
        $this->assign('user_id', session_get('user_id'));
        $this->assign('user_name', session_get('user_name'));
        $authIds = session_get('user_auth');
       
        $this->assign('user_auth', $auth);

    }
}
