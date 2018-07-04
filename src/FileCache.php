<?php
/**
 * Created by PhpStorm.
 * User: zhang
 * Date: 04/07/2018
 * Time: 11:31 AM
 */

namespace phplab\cocache;

class FileCache extends Base
{
    protected function _set($key, $val)
    {
        // Write to temp file first to ensure atomicity
        $tmp = "/tmp/$key." . md5($val) .'.'. uniqid('', true) . '.tmp';
        file_put_contents($tmp, '<?php $val = ' . $val . ';', LOCK_EX);
        rename($tmp, "/tmp/$key");
    }

    protected function _get($key)
    {
        @include "/tmp/$key";
        return isset($val) ? $val : null;
    }
}
