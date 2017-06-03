<?php

namespace core;

class Model extends \Medoo\Medoo
{
    protected static $_instance = null;
    public static function instance()
    {
        if (is_null(static::$_instance) || isset(static::$_instance)) {
            static::$_instance = new static(); //only for php>5.3
        }
        return static::$_instance;
    }

    protected $table = null;
    public function __construct($tableName = null)
    {
        $database = Conf::get_database();
        parent::__construct($database);
        if (is_null($tableName)) {
            //from class name 'app\model\ImageModel' get the name 'Image'
            $this->table = strtolower(
                substr(
                    end(
                        explode('\\',
                            get_called_class()
                        )
                    ), 0, -5));
        } else {
            $this->table = $tableName;
        }

    }

    public function insertObj($datas)
    {
        $res = $this->insert($this->table, $datas);
        return $res->rowCount();
    }

    public function deleteById($id)
    {
        return $this->delete($this->table, ['id' => $id]);
    }

    public function getById($id)
    {
        return $this->get($this->table, '*', ['id' => $id]);
    }

    public function getAll()
    {
        return $this->select($this->table, '*');
    }

    public function getItemsByPage($pageNum = 0, $pageSize = 0, $order = ['id' => 'DESC'], $where = NULL)
    {
        $condiation = [
            'ORDER' => $order,
            'LIMIT' => [$pageNum * $pageSize, $pageSize]
        ];
        if (isset($where)) {
           foreach ($where as $key => $value) {
               $condiation[$key]=$value;
           }
        }
        $res = $this->select($this->table, '*',$condiation);
        return $res;
    }

    public function getNavByPage($pageNum=0, $pageSize = 0,$where = NULL){
        $count = $this->count($this->table,$where);
        $pageCount = ceil($count / (float) $pageSize);
        $pageNav = array();
        array_push($pageNav, ['num' => '«', 'pageIndex' => '0']);
        for ($i = 0; $i < $pageCount; $i++) {
            array_push($pageNav, ['num' => $i + 1,
                'pageIndex' => $i,
                'pageActive' => $pageNum == $i]);
        }
        array_push($pageNav, ['num' => '»', 'pageIndex' => ($pageCount - 1)]);
        return $pageNav;
    }

    public function getCount()
    {
        $res = $this->count($this->table);
        return $res;
    }
}
