<?php
/**
 * Created by PhpStorm.
 * User: zhang
 * Date: 04/07/2018
 * Time: 11:31 AM
 */

namespace phplab\cocache;

abstract class Base extends Cachable
{
    public function cache_set($key, $val)
    {
        $val = var_export($val, true);
        return $this->_set($key, $val);
    }

    public function cache_get($key)
    {
        return $this->_get($key);
    }

    abstract protected function _set($key, $val);

    abstract protected function _get($key);
}
