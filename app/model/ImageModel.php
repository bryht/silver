<?php
namespace app\model;

class ImageModel extends \core\Model
{
    public function addImage($image)
    {
        $res = $this->insert('image', $image);
        return $res;
    }

    public function getImagesByAlbumId($albumId){
        $res=$this->select('image',['album_id'=>$albumId]);
        return $res;
    }
 
    
}
