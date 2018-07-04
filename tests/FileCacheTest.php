<?php
/**
 * Created by PhpStorm.
 * User: zhang
 * Date: 04/07/2018
 * Time: 4:26 PM
 */

namespace phplab\cocache\tests;

use phplab\cocache\FileCache;
use PHPUnit\Framework\TestCase;

class FileCacheTest extends TestCase
{
    /****************************************
     * Function Tests
     ****************************************/
    /**
     * set and get cache
     */
    public function testCache()
    {
        $obj = new FileCache();
        $setter = $obj->cache_set('hello', 'world');
        $getter = $obj->cache_get('hello');

        $this->assertEquals($setter, $getter);
    }
}
