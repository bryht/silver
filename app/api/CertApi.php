<?php

namespace app\api;

/**
 * LoginApi
 */
class CertApi extends \core\Api
{
    public static $authArray=array();
     
    public function __construct($para = null)
    {
        if (isset($para['code']) == false||
            isset(self::$authArray[$para['code']])==false) {
            $this->error('code error. please get code first');
            //exit();
        }
        //$user=self::$authArray[$para['code']];
    
       
        
    }
}
