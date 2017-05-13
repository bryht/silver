<?php

namespace app\control;

class LoginControl extends \core\Control{


    public function login(){
        $this->assign('data', 'Hello');
        $this->display('login.html');
    }

    

}
