<?php

require 'TestBase.php';

use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testAlbum()
    {  
        // $albums= \app\model\AlbumModel::instance()->getAlbumsByUserId(1);
        // print_r($albums);

        $threePictures=\app\model\ImageModel::instance()->getThreeImagesByAlbumId(28);
        print_r($threePictures);
    }
    
}