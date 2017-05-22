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
            ['id', 'name', 'mail', 'password'],
            ['name' => $name, 'password' => $password]);
        if (count($res) > 0) {
            return $res[0];
        } else {
            return false;
        }
    }

}
