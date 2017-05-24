<?php

namespace core;

/**
 * API
 */
class Api
{
    
    
    public function error($error='')
    {
        $res=array();
        $res['ok']=false;
        $res['result']=$error;
        echo json_encode($res);
    }

    public function success($obj)
    {
        $res=array();
        $res['ok']=true;
        $res['result']=$obj;
        echo json_encode($res);
    }



}
