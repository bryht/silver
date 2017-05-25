<?php

namespace app\api;

/**
 * ImageAPi
 */
class ImageApi extends CertApi
{
     public static $count=0;
     public function getImages()
     {
        $res= \app\model\ImageModel::instance()->getImages();
        $this->success($res);
          
     }
}
