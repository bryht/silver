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

    public function getImagesByPage($pageNum = 0, $pageSize =6, $where = null, $order = ['id' => 'DESC'])
    {
        $condiation = [
            'ORDER' => $order,
            'LIMIT' => [$pageNum * $pageSize, $pageSize],
            '[>]user'=>['user_id','id']
        ];
        if (isset($where)) {
            foreach ($where as $key => $value) {
                $condiation[$key] = $value;
            }
        }
        $res = \app\model\ImageModel::instance()->select($this->table, ['size'], $condiation);
      
        $images = array();
        foreach ($res as $key => $value) {
            $value['url'] = '/index/getImageUrlById?id=' . $value['id'];
            $images[$key] = $value;
        }
        return $images;
    }
 
    
}
