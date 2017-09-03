<?php

namespace app\model;

/**
 * 用户表
 */
class UserModel extends \core\Model
{
    public function checkUser($mail, $password)
    {
        $res = $this->select('user',
            ['id', 'name', 'mail', 'password', 'auth'],
            ['mail' => $mail, 'password' => $password]);
        if (count($res) > 0) {
            return $res[0];
        } else {
            return false;
        }
    }

    public function checkRegister($name, $mail)
    {
        $res = $this->count('user', ['OR' => ['name' => $name, 'mail' => $mail]]);
        return $res > 0;
    }



    public function getUsersByAlbumId($albumId)
    {
        $album=AlbumModel::instance()->getObjById($albumId);
        $userIds=$album['user_id'];
        $userIdsArray=explode(',',$userIds);
        $userInfo=$this->select($this->table,['name','avatar'],['id'=>$userIdsArray]);
        return $userInfo;
    }

}
