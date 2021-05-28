<?php


namespace phplab\cocache\utils;


class File
{
    /**
     * @param $path
     * @return bool
     */
    public static function isValidPath($path): bool {
        return preg_match('/^([\/\-\_\.\w]+)$/', $path) > 0;
    }
}