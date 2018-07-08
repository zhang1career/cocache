<?php
/**
 * Created by PhpStorm.
 * User: zhang
 * Date: 04/07/2018
 * Time: 11:31 AM
 */

namespace phplab\cocache;

use phplab\data\safearray\SafeArray;

class Cachable
{
    protected $data;

    public function __construct($data = null)
    {
        $this->data = $data;
    }

    public static function __set_state(SafeArray $data)
    {
        $obj = new static($data['data']);
        return $obj;
    }
}
