<?php

namespace app\control;

class UserControl extends CertControl
{

    public function index($para)
    {
        if (isset($para['page']) == false) {
            $para['page'] = 0;
        }
        $this->assign('users', $this->getUsersByPage($para['page'], 10));
        $this->assign('pageNav', $this->getPageNav($para['page'], 10));

        $this->display('user-index.html');
    }

    public function getAuth()
    {
        $userId = session_get('user_id');
        $userAuth =explode(',',session_get('user_auth'));
        $res = \app\model\MenuModel::instance()->getTreeMenus();
        if ($res) {
            foreach ($res as $key => $value) {
                $this->setTreeMenu($res[$key], $userAuth);
            }
            $this->success($res);

        } else {
            $this->error($res->errorInfo());
        }
    }

    private function setTreeMenu(&$menusTree, $userAuth)
    {
        $menusTree['state']['checked']=in_array((int)$menusTree['id'],$userAuth);
        $menusTree['nodes']=$menusTree['children'];
        $menusTree['nodeId']=(int)$menusTree['id'];
        foreach ($menusTree['nodes'] as $key => $value) {
             $this->setTreeMenu($menusTree['nodes'][$key], $userAuth);
        }
    }

    public function getUsersByPage($pageNum, $pageSize = 6, $where = null)
    {
        $res = \app\model\UserModel::instance()->getItemsByPage($pageNum, $pageSize, $where);

        return $res;
    }

    public function getPageNav($pageNum, $pageSize = 6, $where = null)
    {
        $pageNav = \app\model\UserModel::instance()->getNavByPage($pageNum, $pageSize, $where);
        return $pageNav;
    }

    public function userEdit($para)
    {
        $id = session_get('user_id');
        $res = \app\model\UserModel::instance()->getById($id);

        $this->assign('user', $res);
        $this->display('user-edit.html');

    }

    public function userUpdate($para)
    {
        $name = $para['user-name'];
        $imgFile = $_FILES['img-file'];
        if ($imgFile['size'] > 0) {
            $res = \upload_file($imgFile);
            if ($res['ok']) {
                $user['avatar'] = $res['result'];
            } else {
                $this->redirect500(implode('|', $res['error']));
            }
        }
        $user['id'] = session_get('user_id');
        $user['name'] = $name;
        $resUpdate = \app\model\UserModel::instance()->updateObjById($user, $user['id']);
        if ($resUpdate) {
            goback(-2);
        } else {
            $this->redirect500(implode('|', $resUpdate->errorInfo()));
        }
    }

    public function userDelete($para)
    {
        $id = $para['id'];

        $res = \app\model\UserModel::instance()->deleteById($id);
        if ($res) {
            $this->success($res);
        } else {
            $this->error('delete user failed!');
        }
    }

}
