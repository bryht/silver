<?php

namespace app\control;

use app\model\MenuModel;

class MenuControl extends CertControl
{
    public function index()
    {

        $this->display('menu-index.html');
    }

    public function getMenu()
    {
        $res = \app\model\MenuModel::instance()->getTreeMenus();
        $res = array_values($res);
        if ($res) {
            foreach ($res as $key => $value) {
                $this->setTreeMenu($res[$key]);
            }
            $this->success($res);
        } else {
            $this->error($res->errorInfo());
        }
    }

    public function delete($para)
    {
        $id = $para['id'];
        $res=MenuModel::instance()->deleteById($id);
        if ($res) {
            $this->success($res);
        } else {
            $this->error($res->errorInfo());
        }
        
    }

    private function setTreeMenu(&$menusTree)
    {
        if ($menusTree['hasChildren']) {
            $menusTree['nodes'] = $menusTree['children'];
            foreach ($menusTree['nodes'] as $key => $value) {
                $this->setTreeMenu($menusTree['nodes'][$key]);
            }
        }
    }
}
