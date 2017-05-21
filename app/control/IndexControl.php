<?php

namespace app\Control;

class IndexControl extends CertControl
{
    public function index()
    {
        $this->assign('images',$this->getImages());
        $this->display('index.html');
    }

    public function add()
    {

        $this->display('index-add.html');
    }

    public function upload($para)
    {
        p($para);
        $description = $para['img-description'];
        $time = $para['img-time'];
        $imgFile = $_FILES['img-file'];

        $res = \upload_file($imgFile);
        if ($res['ok']) {
            $img['name'] = $imgFile['name'];
            $img['type'] = $imgFile['type'];
            $img['size'] = $imgFile['size'];
            $img['path'] = $res['result'];
            $img['description'] = $description;
            $res = \app\model\ImageModel::instance()->addImage($img);
            if ($res) {
                $this->redirect('index', 'index');
            }

        } else {
            throw new Exception($res['error'], 1);

        }

    }

    public function getImages()
    {
        $res = \app\model\ImageModel::instance()->getImages();
        $images=array();
        foreach ($res as $key => $value) {
            $value['url'] = '/index/getImageUrl?id='.$value['id'];
            $images[$key]=$value;
        }
        return $images;
    }

    public function getImageUrl($para)
    {
        $res = \app\model\ImageModel::instance()->getImageById($para['id']);
        $filePath = SILVER . $res['path'];
        $imageForm = getimagesize($filePath)['mime'];
        $imageSource = fread(fopen($filePath, 'rb'), filesize($filePath));
        header('content-type:' . $imageForm);
        echo $imageSource;
    }

}
