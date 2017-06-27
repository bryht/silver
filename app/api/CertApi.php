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

        try
        {
            $id = explode('-', $para['code'])[0];
            $code = $para['code'];
            $codeCompare = \core\Cache::instance()->fetch($id)['code'];
            if ($code != $codeCompare && DEBUG == false) {
                //TODO:DEBUG mode will not vertify
                throw new \Exception("code is not same", 1);
            }
        } catch (\Exception $e) {

            $this->error($e->getMessage());
            exit();
        }

    }

}
