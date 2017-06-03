<?php

namespace app\Control;

class IndexControl extends CertControl
{
    public function index($para)
    {
        if (isset($para['page']) == false) {
            $para['page'] = 0;
        }
        $this->assign('images', $this->getImagesByPage($para['page']));
        $this->assign('pageNav', $this->getPageNav($para['page']));
        $this->display('index.html');
    }

    public function album($para){
        $category=$para['category'];
        $where=$para['where'];
        $page=$para['page'];


    }

    public function add()
    {
        $this->display('index-add.html');
    }

    public function edit($para)
    {
        $id = $para['id'];
        $image = \app\model\ImageModel::instance()->getById($id);
        $this->assign('image', $image);
        $this->display('index-add.html');
    }

    public function delete($para)
    {
        $id = $para['id'];
        $res = \app\model\ImageModel::instance()->deleteById($id);
        $count = $res->rowCount();
        $this->result($count > 0, $id, '删除失败！');
    }

    public function upload($para)
    {
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
            $this->redirect('index', 'index');

        } else {
            throw new Exception($res['error'], 1);
        }
    }

    public function getImagesByPage($pageNum, $pageSize = 6)
    {
        $res = \app\model\ImageModel::instance()->getItemsByPage($pageNum, $pageSize);
        $images = array();
        foreach ($res as $key => $value) {
            $value['url'] = '/index/getImageUrlById?id=' . $value['id'];
            $images[$key] = $value;
        }
        return $images;
    }

    public function getPageNav($pageNum, $pageSize = 6)
    {
        $pageNav = \app\model\ImageModel::instance()->getNavByPage($pageNum, $pageSize);
        return $pageNav;
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

    public function galleryAdd($para)
    {
        $this->display('gallery-add.html');
    }

    public function galleryUpdate($para){
        $data['name']=$para['gallery-name'];
        $data['music_link']=$para['music-link'];
        $data['create_time']=date('Y-m-d H:i:s');
        $data['user_id']=session_get('user_id');
         
        $res=\app\model\GalleryModel::instance()->insertObj($data);
        if ($res>0) {
            $this->redirect('index','index');
        }else {
            $this->redirect500(serialize($res));
        }
    }
}
