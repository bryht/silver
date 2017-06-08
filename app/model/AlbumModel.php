<?php

namespace app\model;

class AlbumModel extends \core\Model
{
    public function getAlbumsByUserId($userid)
    {
        $where=','.intval($userid).',';
        return $this->select('album','*', ['user_id[~]' => $where]);
    }
}
