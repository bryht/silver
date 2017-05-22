<?php

namespace app\Control;

class IndexControl extends CertControl
{
    public function index($para)
    {
        if (count($para) == 0) {
            $para['page'] = 0;
        }
        $this->assign('images', $this->getImagesByPage($para['page']));
        $this->assign('pageNav', $this->getPageNav($para['page']));
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

    public function getImagesByPage($pageNum, $pageSize = 6)
    {
        $res = \app\model\ImageModel::instance()->getImagesByPage($pageNum, $pageSize);
        $images = array();
        foreach ($res as $key => $value) {
            $value['url'] = '/index/getImageUrlById?id=' . $value['id'];
            $images[$key] = $value;
        }
        return $images;
    }

    public function getPageNav($pageNum, $pageSize = 6)
    {
        $res = \app\model\ImageModel::instance()->getImagesCount();
        $pageCount = ceil($res / (float) $pageSize);
        $pageNav = array();

        array_push($pageNav, ['num' => '«', 'url' => '/index/index?page=0']);
        for ($i = 0; $i < $pageCount; $i++) {
            $pageActive=\FALSE;
            if ($pageNum == $i) {
                $pageActive = true;
            }
            \array_push($pageNav, ['num' => $i + 1,
                'url' => '/index/index?page=' . $i,
                'pageActive' => $pageActive]);
        }
        array_push($pageNav, ['num' => '»', 'url' => '/index/index?page=' . ($pageCount - 1)]);
        return $pageNav;
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
