<?php

namespace app\Control;

class IndexControl extends CertControl
{
    public function index()
    {
        $this->display('index.html');
    }

    public function add()
    {

        $this->display('index-add.html');
    }

    public function upload($para)
    {
        p($para);
        $description = $para['img-description'];
        $time = $para['img-time'];
        $imgFile = $_FILES['img-file'];

        // Array ( [name] => 1.jpg [type] => image/jpeg
        //  [size] => 16139 )
        $res = \upload_file($imgFile);
        if ($res['ok']) {
           $img['name']=$imgFile['name'];
           $img['type']=$imgFile['type'];
           $img['size']=$imgFile['size'];
           $img['path']=$res['result'];
           $img['description']=$description;
           $res= \app\model\ImageModel::instance()->addImage($img);
           if ($res) {
               $this->redirect('index','index');
           }

        } else {
            throw new Exception($res['error'], 1);
            
        }

    }

    public function getImage(){

    }

    public function page()
    {
        $this->assign('data', 'Hello');
        $this->display('index.html');
    }
}
