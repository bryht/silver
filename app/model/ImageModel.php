<?php
namespace app\model;

class ImageModel extends \core\Model
{
    public function addImage($image)
    {
        $res = $this->insert('image', $image);
        return $res;
    }
 
    
}
