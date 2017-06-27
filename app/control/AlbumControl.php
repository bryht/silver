<?php

namespace app\control;

class AlbumControl extends CertControl
{
    public function getAlbum()
    {
        $userId = session_get('user_id');
        $res = \app\model\AlbumModel::instance()->getAlbumsByUserId($userId);
        $this->result(count($res) > 0, $res, $res);
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
        if ($res > 0) {
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

        $res = \app\model\AlbumModel::instance()->updateObjById($data, $data['id']);
        if ($res) {
            $this->redirect('index', 'index', ['album_id' => $data['id']]);
        } else {
            $this->redirect500(implode('|', $res->errorInfo()));
        }
    }

    public function albumDelete($para)
    {
        $id = $para['album_id'];
        $res = \app\model\AlbumModel::instance()->deleteById($id);
        $albumIds = \app\model\AlbumModel::instance()->getAlbumsByUserId(session_get('user_id'));
        if (count($albumIds) > 0) {
            $firstAlbumId = $albumIds[0]['id'];
        } else {
            $firstAlbumId = -1;
        }
        $this->result($res->rowCount() > 0, $firstAlbumId, '删除失败！');

    }

    public function albumShare($value = '')
    {
        $this->display('album-share.html');
    }

    public function albumShareUpdate($value = '')
    {
        $email = $value['user-email'];
        $album_id=$value['album-id'];
        $name = session_get('user_name');
        $album=\app\model\AlbumModel::instance()->getById($album_id);
        $images=\app\model\ImageModel::instance()->getThreeImagesByAlbumId($album_id);
        //ablum-text image1 mail

        $templateName = VIEW . 'album-share-email.html';
        $content = file_get_contents($templateName);
        $para = array('name' => $name,
        'album-text'=> $album['name'],
        'image1'=>$images[0]['path'],
        'image2'=>$images[1]['path'],
        'image3'=>$images[2]['path'],
        'mail'=>$email);
        $res = sendMaill($email, $name . ' share an album to you', $content, $para);
        if ($res != true) {
            echo $res;
        } else {
            goback(-2);
        }
    }

}
