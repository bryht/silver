<?php

namespace app\api;
header('Access-Control-Allow-Origin: *');

/**
 * LoginApi
 */
class CertApi extends \core\Control
{
    public static $authArray = array();

    public function __construct($para = null)
    {
        if (isset($para['code']) == false ||
             \core\Cache::instance()->contains($para['code']) == false) {
            //TOOD: add expire date judge
            $this->error('code error. please get code first');
            exit();
        }
    }

}
