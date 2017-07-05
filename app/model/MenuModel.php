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
            self::$_menus = self::instance()->getAll();
        }
        $menusArray = explode(',', $ids);

        $res = array_uintersect(self::$_menus, $menusArray, 'self::compareId');

        return $res;
    }

    public function getTreeMenusByAuthIds($ids)
    {
        if (is_null(self::$_menus) || isset(self::$_menus)) {
            self::$_menus = self::instance()->getAll();
        }
        $menusAuthIds = explode(',', $ids);

        $menusByAuth = array_uintersect(self::$_menus, $menusAuthIds, function ($v1, $v2) {
            if (is_array($v1)) {
                $v1 = $v1['id'];
            }
            if (is_array($v2)) {
                $v2 = $v2['id'];
            }
            if ((int) $v1 === (int) $v2) {
                return 0;
            } else {
                return ((int) $v1 > (int) $v2) ? 1 : -1;
            }

        });
        $menus = array();

        $this->setTreeMenu(0, $menus, $menusByAuth);

        return $menus['children'];
    }

    protected static $_flagParentId = null;
    private function setTreeMenu($parentId, &$menusTree, $menusByAuth)
    {
        self::$_flagParentId = $parentId;

        $menusTree['children'] = array_filter($menusByAuth, function ($item) {
            if ($item['parent_id'] == self::$_flagParentId) {
                return true;
            }
        });
        $menusTree['hasChildren'] = count($menusTree['children']) > 0 ? true : false;
        foreach ($menusTree['children'] as $key => $value) {
            $this->setTreeMenu($menusTree['children'][$key]['id'], $menusTree['children'][$key], $menusByAuth);
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
        } else {
            return ((int) $v1 > (int) $v2) ? 1 : -1;
        }
    }

}
