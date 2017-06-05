<?php

namespace app\Control;

class IndexControl extends CertControl
{
    public function index($para)
    {
        if (isset($para['page']) == false) {
            $para['page'] = 0;
        }
        $where = ['album_id' => 0];
        if (isset($para['album_id'])) {
            //TODO judge the user have the right to access the album
            $where = ['album_id' => $para['album_id']];
        }

        $this->assign('images', $this->getImagesByPage($para['page'], 6, $where));
        $this->assign('pageNav', $this->getPageNav($para['page'], 6, $where));
        $this->display('index.html');
    }

    public function getAlbum()
    {
        $userId = session_get('user_id');
        $res = \app\model\AlbumModel::instance()->getAlbumsByUserId($userId);
        $this->result(count($res) > 0, $res, $res);
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
        $albumId = $para['album_id'];
        $imgFile = $_FILES['img-file'];

        $res = \upload_file($imgFile);
        if ($res['ok']) {
            $img['name'] = $imgFile['name'];
            $img['type'] = $imgFile['type'];
            $img['size'] = $imgFile['size'];
            $img['path'] = $res['result'];
            $img['user_id'] = session_get('user_id');
            $img['album_id'] = $albumId;
            $img['create_time'] = $time;
            $img['description'] = $description;
            $res = \app\model\ImageModel::instance()->insertObj($img);
            $this->redirect('index', 'index', ['album_id' => $albumId]);

        } else {
            throw new Exception($res['error'], 1);
        }
    }

    public function getImagesByPage($pageNum, $pageSize = 6, $where = null)
    {
        $res = \app\model\ImageModel::instance()->getItemsByPage($pageNum, $pageSize, $where);
        $images = array();
        foreach ($res as $key => $value) {
            $value['url'] = '/index/getImageUrlById?id=' . $value['id'];
            $images[$key] = $value;
        }
        return $images;
    }

    public function getPageNav($pageNum, $pageSize = 6, $where = null)
    {
        $pageNav = \app\model\ImageModel::instance()->getNavByPage($pageNum, $pageSize, $where);
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

    public function albumAdd($para)
    {
        $this->display('album-add.html');
    }

    public function albumEdit($para)
    {
        $id = $para['album_id'];
        $res = \app\model\AlbumModel::instance()->getById($id);

        $this->assign('album', $res);
        $this->display('album-edit.html');
    }

    public function albumInsert($para)
    {
        $data['name'] = $para['gallery-name'];
        $data['music_link'] = $para['music-link'];
        $data['create_time'] = date('Y-m-d H:i:s');
        $data['create_userid'] = session_get('user_id');
        $data['user_id'] = ',' . intval(session_get('user_id')) . ',';
        $res = \app\model\AlbumModel::instance()->insertObj($data);
        if (intval($res) > 0) {
            $this->redirect('index', 'index', ['album_id' => $res]);
        } else {
            $this->redirect500(implode('|', $res->errorInfo()));
        }
    }

    public function albumUpdate($para)
    {
        $data['id'] = $para['album_id'];
        $data['name'] = $para['gallery-name'];
        $data['music_link'] = $para['music-link'];

        $res = \app\model\AlbumModel::instance()->updateObj($data);
        if (intval($res) > 0) {
            $this->redirect('index', 'index', ['album_id' => $res]);
        } else {
            $this->redirect500(implode('|', $res->errorInfo()));
        }
    }

    public function albumDelete($para)
    {
        $id = $para['album_id'];
        $res = \app\model\AlbumModel::instance()->deleteById($id);
        if ($res->rowCount() > 0) {
            $this->redirect('index', 'index', ['album_id' =>-1]);
        } else {
            $this->redirect500(implode('|', $res->errorInfo()));
        }
    }

    public function userUpdate($para)
    {
        $name=$para['user-name'];
        $imgFile = $_FILES['img-file'];
        $album_id = $para['album_id'];

        $res = \upload_file($imgFile);
        if ($res['ok']) {
            
            $user['path'] = $res['result'];
            $user['user_id'] = session_get('user_id');
            $user['name'] =$name;
          
            $res = \app\model\UserModel::instance()->updateObj($user);
            $this->redirect('index', 'index', ['album_id' => $album_id]);

        } else {
            throw new Exception($res['error'], 1);
        }
    }
}
