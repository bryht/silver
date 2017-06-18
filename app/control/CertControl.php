<?php

namespace app\control;

class CertControl extends \core\Control
{
    public function __construct($para = null)
    {
        if (session_get('user_id') == false) {
            $this->redirect('login', 'login');
        }
        
        $authIds=session_get('user_auth');
        $auth=\app\model\MenuModel::instance()->getMenusByIds($authIds);
        $user=\app\model\UserModel::instance()->getById(session_get('user_id'));
        $this->assign('user',$user);
        $this->assign('user_auth',$auth);
        
    }


}