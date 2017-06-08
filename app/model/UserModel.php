<?php

namespace app\model;

/**
 * 用户表
 */
class UserModel extends \core\Model
{
    public function checkUser($name, $password)
    {
        $res = $this->select('user',
            ['id', 'name', 'mail', 'password', 'auth'],
            ['name' => $name, 'password' => $password]);
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

    public function getUserListByIds($ids)
    {
        $res=$this->select($this->table,['name','avatar'],['id'=>$ids]);
        return $res;
    }

}
