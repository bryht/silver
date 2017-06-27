<?php

namespace app\control;

class UserControl extends CertControl
{


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

}