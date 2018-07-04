<?php
/**
 * Created by PhpStorm.
 * User: zhang
 * Date: 04/07/2018
 * Time: 4:26 PM
 */

namespace phplab\cocache\tests;

use phplab\cocache\FileCache;

require_once __DIR__ . '/../vendor/autoload.php';


$obj = new FileCache();
$setter = $obj->cache_set('hello', 'world');
$getter = $obj->cache_get('hello');

var_dump($getter);

