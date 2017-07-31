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
            $this->error('get menu null!');
        }
    }

    public function delete($para)
    {
        $id = $para['id'];
        $res = MenuModel::instance()->deleteObjById($id);
        $this->result($res['ok'],'',$res['pdoStatement']->errorInfo());
    }

    public function add($para)
    {
        $res = MenuModel::instance()->insertObj($para);
        $this->result($res['ok'],$res['id'],$res['pdoStatement']->errorInfo());
    }

    public function update($para)
    {
        $res = MenuModel::instance()->updateObjById($para,$para['id']);
        $this->result($res['ok'],'update success!',$res['pdoStatement']->errorInfo());
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
