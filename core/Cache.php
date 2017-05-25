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
            static::$_instance = new static(CACHE . 'file\\'); //only for php>5.3
        }
        return static::$_instance;
    }

    public function save($id, $data, $lifeTime = 0)
    {
        return parent::doSave($id, $data, $lifeTime);
    }

    public function fetch($id)
    {
        return parent::doFetch($id);
    }

    public function delete($id)
    {
        return parent::doDelete($id);
    }

    public function contains($id)
    {
        return parent::doContains($id);
    }

    public function flushAll()
    {
        return parent::doFlush();
    }

}
