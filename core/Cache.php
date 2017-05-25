<?php

namespace core;

/**
 * Cache
 */
class Cache extends \Doctrine\Common\Cache\FilesystemCache
{
    protected static $_instance = null;
    public static function instance()
    {
        if (is_null(static::$_instance) || isset(static::$_instance)) {
            static::$_instance =  new static(CACHE);//only for php>5.3
        }
        return static::$_instance;
    }

    public function doSave($id, $data, $lifeTime = 0)
    {
        return $this->doSave($id,$data,$lifeTime);
    }

}
