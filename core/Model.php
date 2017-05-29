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

    public function deleteById($id)
    {
        return $this->delete($this->table, ['id' => $id]);
    }

    public function getById($id)
    {
        return $this->get($this->table, '*', ['id' => $id]);
    }

    public function getAll(){
        return $this->select($this->table,'*');
    }
}
