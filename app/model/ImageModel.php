<?php
namespace app\model;

class ImageModel extends \core\Model
{
    public function addImage($image)
    {
        $res = $this->insert('image', $image);
        return $res;
    }

    public function getImagesByAlbumId($albumId)
    {
        $res = $this->select('image', ['album_id' => $albumId]);
        return $res;
    }

    public function getImagesByPage($pageNum = 0, $pageSize = 6, $where = null, $order = ['id' => 'DESC'])
    {
        $condiation = [
            'ORDER' => $order,
            'LIMIT' => [$pageNum * $pageSize, $pageSize],
        ];
        if (isset($where)) {
            foreach ($where as $key => $value) {
                $condiation[$key] = $value;
            }
        }
        $leftJoin = ['[>]user' => ['user_id', 'id']];
        $res = \app\model\ImageModel::instance()->select($this->table,
            ['[>]user' => ['user_id' => 'id']],
            ['image.id', 'image.name','image.user_id','image.create_time', 'user.avatar', 'user.name(username)'], 
            $condiation);
        return $res;

    }

}
