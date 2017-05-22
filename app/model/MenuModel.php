<?php

namespace app\model;

/**
 * Menu
 */
class MenuModel extends \core\Model
{
    public function getMenuByAuth($auth)
    {
        $authArray = explode(',', $auth);
        $res = $this->select('menu', '*', ['id' => $authArray]);
        return $res;
    }

    protected static $_menus = null;
    public function getMenusByIds($ids)
    {
        if (is_null(self::$_menus) || isset(self::$_menus)) {
            self::$_menus = self::instance()->select('menu', '*');
        }
        $menusArray = explode(',', $ids);

        $res = array_uintersect(self::$_menus, $menusArray, 'self::compareId');

        return $res;
    }

    public static function compareId($v1, $v2)
    {
        if (is_array($v1)) {
            $v1 = $v1['id'];
        }
        if (is_array($v2)) {
            $v2 = $v2['id'];
        }
        if ((int) $v1 === (int) $v2) {
            return 0;
        }
        return 1;
    }

}
