<?php

namespace app\model;

/**
 * Menu
 */
class MenuModel extends \core\Model
{

    protected static $_menus = null;
    public function getMenusByAuthIds($ids)
    {
        if (is_null(self::$_menus) || isset(self::$_menus)) {
            self::$_menus = self::instance()->select('menu', '*');
        }
        $menusArray = explode(',', $ids);

        $res = array_uintersect(self::$_menus, $menusArray, 'self::compareId');

        return $res;
    }

    public function getTreeMenusByAuthIds($ids)
    {
        if (is_null(self::$_menus) || isset(self::$_menus)) {
            self::$_menus = self::instance()->select('menu', '*');
        }

        $menusAuthIds = explode(',', $ids);
        $menusByAuth = array_uintersect(self::$_menus, $menusAuthIds, 'self::compareId');
        $menusTree = array();
        $this->setTreeMenu(0, $menusTree, $menusByAuth);
        return $menusTree['children'];
    }

    protected static $_flagParentId = null;
    private function setTreeMenu($parentId, &$menuItem, $menusByAuth)
    {
        self::$_flagParentId = $parentId;

        $menuItem['children'] = array_filter($menusByAuth, function ($item) {
            if ($item['parent_id'] == self::$_flagParentId) {
                return true;
            }
        });
        $menuItem['hasChildren'] = count($menuItem['children']) > 0 ? true : false;
        foreach ($menuItem['children'] as $key => $value) {
            $this->setTreeMenu($menuItem['children'][$key]['id'], $menuItem['children'][$key], $menusByAuth);
        }
    }

    private static function compareId($v1, $v2)
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
