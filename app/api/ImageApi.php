<?php

namespace app\api;

/**
 * ImageAPi
 */
class ImageApi extends CertApi
{
    public static $count = 0;
    public function getImages($para)
    {
        $res = \app\model\ImageModel::instance()->getImages();
        
        $images = array();
        foreach ($res as $key => $value) {
            $value['url'] = '/api/image/getImageUrlById?id=' . $value['id'].'&'.'code='.$para['code'];
            $images[$key] = $value;
        }

        $this->success($images);

    }

    public function getImageUrlById($para)
    {
        $res = \app\model\ImageModel::instance()->getImageById($para['id']);
        $filePath = SILVER . $res['path'];
        $imageForm = getimagesize($filePath)['mime'];
        $imageSource = fread(fopen($filePath, 'rb'), filesize($filePath));
        header('content-type:' . $imageForm);
        echo $imageSource;
    }

}
