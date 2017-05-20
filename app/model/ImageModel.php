<?php
namespace app\model;

class ImageModel extends \core\Model
{
    public function addImage($image){
        $res=$this->insert('images',$image);
       p( $this->log());
        return $res;
    }
}