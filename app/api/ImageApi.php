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
        $res = \app\model\ImageModel::instance()->getAll();
        foreach ($res as $key => $value) {
            $res[$key]['url'] = "/api/image/getImageUrlById?id={$value['id']}&code={$para['code']}";
        }
        $this->success($res);
    }

    public function getImageUrlById($para)
    {
        $res = \app\model\ImageModel::instance()->getById($para['id']);
        $filePath = SILVER . $res['path'];
        $imageForm = getimagesize($filePath)['mime'];
        $imageSource = fread(fopen($filePath, 'rb'), filesize($filePath));
        header('content-type:' . $imageForm);
        echo $imageSource;
    }

}
