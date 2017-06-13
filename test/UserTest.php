<?php

require '..\vendor\autoload.php';
use PHPUnit\Framework\TestCase;


class UserTest extends TestCase
{
    // public function testExpectFooActualFoo()
    // {
    //     $this->expectOutputString('foo');
    //     print 'foo';
    // }

    // public function testExpectBarActualBaz()
    // {
    //     $this->expectOutputString('bar');
    //     print 'baz';
    // }

    public function testPushAndPop()
    {
        $stack = [];
        $this->assertEquals(0, count($stack));

        array_push($stack, 'foo');
        $this->assertEquals('foo', $stack[count($stack)-1]);
        $this->assertEquals(1, count($stack));

        $this->assertEquals('foo', array_pop($stack));
        $this->assertEquals(0, count($stack));
    }

    // public function testNewArrayIsEmpty()  
    // {  
    //     // 创建数组fixture。  
    //     $fixture = array();  
   
    //     // 断言数组fixture的尺寸是0。  
    //     $this->assertEquals(0, sizeof($fixture));  
    // }  
}