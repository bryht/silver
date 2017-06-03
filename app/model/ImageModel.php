<?php
namespace app\model;

class ImageModel extends \core\Model
{
    public function addImage($image)
    {
        $res = $this->insert('image', $image);
        return $res;
    }

    public function getImages()
    {
        $res = $this->select('image', ['id', 'name', 'description']);
        return $res;
    }


    public function getImageById($id)
    {
        $res = $this->select('image', '*', ['id' => $id]);
        if (count($res) == 1) {
            return $res[0];
        } else {
            throw new Exception("Error:" . $res, 1);
        }
    }

    
    
}
