<?php

namespace app\control;

class IndexControl extends CertControl
{
    public function index($para)
    {
        if (isset($para['page']) == false) {
            $para['page'] = 0;
        }

        $userId = session_get('user_id');
        $albums = \app\model\AlbumModel::instance()->getAlbumsByUserId($userId);
        $haveAlbumAuth = false;
       
        for ($i = 0; $i < count($albums); $i++) {
            if (isset($para['album_id']) == false) {
               $para['album_id']=$albums[$i]['id'];
            }
            if ($albums[$i]['id'] == $para['album_id']) {
                $albums[$i]['active'] = true;
                $haveAlbumAuth = true;
            }
        }
        
        if ($haveAlbumAuth == false) {
            $this->assign('message', 'have not auth to access this album');
            $this->display('common/message.html');
            exit();
        }

        $album = \app\model\AlbumModel::instance()->getById($para['album_id']);
        $albumUsers = \app\model\UserModel::instance()->getUsersByAlbumId($para['album_id']);

        $this->assign('album', $album);
        $this->assign('albums', $albums);
        $this->assign('albumControl', $album['create_userid'] == $userId);
        $this->assign('albumUsers', $albumUsers);

        $this->assign('images', $this->getImagesByPage($para['page'], 6, ['album_id' => $para['album_id']]));
        $this->assign('pageNav', $this->getPageNav($para['page'], 6, ['album_id' => $para['album_id']]));
        $this->display('index-index.html');
    }

    public function add()
    {
        $this->display('index-add-edit.html');
    }

    public function edit($para)
    {
        $id = $para['id'];
        $image = \app\model\ImageModel::instance()->getById($id);
        $this->assign('image', $image);
        $this->display('index-add-edit.html');
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
        $imageSource = $para['img-source'];
        $imageName = $para['img-name'];
        $imageType = $para['img-type'];
        $imageSize = $para['img-size'];

        $res = base64_to_file($imageName, $imageSource);

        if ($res['ok']) {
            $img['name'] = $imageName;
            $img['type'] = $imageType;
            $img['size'] = $res['size'];
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
        $res = \app\model\ImageModel::instance()->getImagesByPage($pageNum, $pageSize, $where);
        $images = array();
        foreach ($res as $key => $value) {
            $res[$key]['url'] = '/index/getImageUrlById?id=' . $value['id'];
            $res[$key]['control'] = ($value['user_id'] == session_get('user_id'));
        }
        return $res;
    }

    public function getPageNav($pageNum, $pageSize = 6, $where = null)
    {
        $pageNav = \app\model\ImageModel::instance()->getNavByPage($pageNum, $pageSize, $where);
        return $pageNav;
    }

    public function getImageUrlById($para)
    {
        $res = \app\model\ImageModel::instance()->getById($para['id']);
        $path = str_replace('\\', '/', $res['path']);
        $filePath = SILVER_BASE . $path;
        $imageForm = getimagesize($filePath)['mime'];
        $imageSource = fread(fopen($filePath, 'rb'), filesize($filePath));
        header('content-type:' . $imageForm);
        echo $imageSource;
    }

}
