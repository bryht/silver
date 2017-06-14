<?php



define('SILVER', realpath(__DIR__) . '/');
require '..\vendor\autoload.php';
require '..\core\Function.php';
require '..\core\Silver.php';
require '..\core\Model.php';

spl_autoload_register('core\Silver::load');

//require '..\index.php';
use PHPUnit\Framework\TestCase;


class UserTest extends TestCase
{
    public function testExpectFooActualFoo()
    {
        //$this->expectOutputString('foo');
      // $albums= \app\model\AlbumModel::instance()->getAlbumsByUserId(1);
    
        //p($albums);
       
        $albums= \app\model\AlbumModel::instance()->getAlbumsByUserId(1);
    }

   

    
}