<?php
namespace app\model;

class ImageModel extends \core\Model
{
    public function addImage($image){
        $res=$this->insert('images',$image);
        return $res;
    }

    public function getImages(){
        $res=$this->select('images',['id','name','description']);
        return $res;
    }

    public function getImageById($id){
        
        $res=$this->select('images','*',['id'=>$id]);
        if (count($res)==1) {
            return $res[0];
        }else{
            throw new Exception("Error:".$res, 1);
        }

    }

    public function getImagesPage($pageIndex,$pageSize){

    }
}