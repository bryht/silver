<?php
namespace app\Control;

/**
 * 菜单
 */
class MenuControl extends CertControl
{

     public function getMenuByAuth(){
          $authIds=session_get('user_auth');
        $auth=\app\model\MenuModel::instance()->getMenusByIds($authIds);
       p($auth);
     }

}
