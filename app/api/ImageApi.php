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

    public function getImagesByAlbumId($para){
        $res=\app\model\ImageModel::instance()->getImagesByAlbumId($para['album_id']);
        $this->result(count($res)>0,$res,$res->errorInfo());
    }

    public function getImageUrlById($para)
    {
        $res = \app\model\ImageModel::instance()->getObjById($para['id']);
        $path = str_replace('\\', '/', $res['path']);
        $filePath = SILVER_BASE . $path;
        $imageForm = getimagesize($filePath)['mime'];
        $imageSource = fread(fopen($filePath, 'rb'), filesize($filePath));
        header('content-type:' . $imageForm);
        echo $imageSource;
    }

    /*TODO:TEst*/
    public function getImagesByPage($para)
    {
        $res= \app\model\ImageModel::instance()->getImagesByPage(0,6);
        p($res);
    }
    
    /*TODO:TEst*/
    public function getUsersByAlbumId(){
        $res=\app\model\UserModel::instance()->getUsersByAlbumId(7);
        p($res);
    }

}
