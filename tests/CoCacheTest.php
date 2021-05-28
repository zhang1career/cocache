<?php
/**
 * Created by PhpStorm.
 * User: zhang
 * Date: 04/07/2018
 * Time: 4:26 PM
 */

namespace phplab\cocache\tests;

use phplab\cocache\CoCache;
use PHPUnit\Framework\TestCase;

class CoCacheTest extends TestCase
{
    /****************************************
     * Unit Tests
     ****************************************/
    public function test_cacheSetAndGet_string() {
        $key = 'hello';
        $data = 'world';
        $this->assertTrue(CoCache::cacheSet($key, $data));
        $this->assertEquals($data, CoCache::cacheGet($key));
    }

    public function test_cacheSetAndGet_array() {
        $key = 'hello';
        $data = [
            'lorem'         => 'tempor',
            'ipsum'         => 'incididunt',
            'dolor'         => 'ut',
            'sit'           => 'labore',
            'amet'          => 'et',
            'consectetur'   => 'dolore',
            'adipiscing'    => 'magna',
            'elit'          => 'aliqua',
            'sed'           => 'Ut',
            'eiusmod'       => [
                'enim', 'beatae', 'vitae', 'dicta', 'sunt', 'explicabo'
            ]
        ];
        $this->assertTrue(CoCache::cacheSet($key, $data));
        $this->assertEquals($data, CoCache::cacheGet($key));
    }

    public function test_cacheSetAndGet_object() {
        $key = 'hello';
        $data = new Foo();
//        CoCache::cacheSet($key, $data);
        apcu_store($key, $data);

//        $ccObj = CoCache::cacheGet($key);
//        $this->assertEquals('hello world', $ccObj->toString());

        $apcObj = apcu_fetch($key);
        $this->assertEquals('hello world', $apcObj->toString());
    }


    /****************************************
     * Performance Tests
     ****************************************/
    public function test_fileCache_vs_apc() {
        $key = 'hello';
        $data = array_fill(0, 100000, 'world');
        CoCache::cacheSet($key, $data);
        apc_store($key, $data);

        $start = microtime(true);
        for ($i = 0; $i < 30; $i++) {
            $this->assertNotNull(CoCache::cacheGet($key));
        }
        $ccTime = microtime(true) - $start;
        var_dump($ccTime);

        $start = microtime(true);
        for ($i = 0; $i < 30; $i++) {
            $this->assertNotNull(apc_fetch($key));
        }
        $apcTime = microtime(true) - $start;
        var_dump($apcTime);
    }
}

class Foo {
    private $field1 = 'hello';
    private $field2 = 'world';

//    public static function __set_state($array)
//    {
//        $obj = new static;
//        $obj->field1 = $array['field1'];
//        $obj->field2 = $array['field2'];
//        return $obj;
//    }

    public function toString() {
        return $this->field1 . ' ' . $this->field2;
    }
}