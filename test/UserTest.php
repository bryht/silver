<?php

require 'TestBase.php';

use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testAlbum()
    {  
        // $albums= \app\model\AlbumModel::instance()->getAlbumsByUserId(1);
        // print_r($albums);

       $menu=\app\model\MenuModel::instance()->getTreeMenusByAuthIds('1,2,3');
        print_r($menu);
    }
    
}