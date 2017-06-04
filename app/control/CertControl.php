<?php

namespace app\Control;

class CertControl extends \core\Control
{
    public function __construct($para = null)
    {
        if (session_get('user_id') == false) {
            $this->redirect('login', 'login');
        }
        $this->assign('user_id', session_get('user_id'));
        $this->assign('user_name', session_get('user_name'));
        $authIds=session_get('user_auth');
        $auth=\app\model\MenuModel::instance()->getMenusByIds($authIds);
        $this->assign('user_auth',$auth);
        
    }


}