<?php

namespace app\api;

/**
 * LoginApi
 */
class CertApi extends \core\Api
{
    public static $authArray = array();

    public function __construct($para = null)
    {
        if (isset($para['code']) == false ||
            session_get($para['code']) == false) {
            //TOOD: add expire date judge
            $this->error('code error. please get code first');
            exit();
        }

    }
}
