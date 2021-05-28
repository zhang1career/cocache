<?php
/**
 * Created by PhpStorm.
 * User: zhang
 * Date: 04/07/2018
 * Time: 11:31 AM
 */

namespace phplab\cocache;

use InvalidArgumentException;
use phplab\cocache\utils\File;

/**
 * todo: opcache_invalidate() prevents stale data read
 * If you want to precompile/cache the newly written data,
 * you have to "touch" it first to pretend the file is 2 seconds older than it is,
 * because opcache will not do it if the file is newer than the script execution time.
 *   touch($path, time()-2);
 *   opcache_compile_file($path);`
 *
 * Class CoCache
 * @package phplab\cocache
 */
class CoCache
{
    const PATH_PREFIX = '/tmp/opcache/cocache/';
    const ERRMSG_INVALID_ARGUMENT_KEYS_CHARACTER = 'Keys character is not supported.';


    public static function cacheSet($key, $val) : bool {
        if (!File::isValidPath($key)) {
            throw new InvalidArgumentException(self::ERRMSG_INVALID_ARGUMENT_KEYS_CHARACTER);
        }
        // HHVM fails at __set_state, so just use object cast for now
//        $exp = str_replace('stdClass::__set_state', '(object)', var_export($val, true));
        $exp = var_export($val, true);
        return self::write($key, $exp);
    }


    public static function cacheGet($key) {
        if (!File::isValidPath($key)) {
            throw new InvalidArgumentException(self::ERRMSG_INVALID_ARGUMENT_KEYS_CHARACTER);
        }
        return self::read($key);
    }


    /**
     * @param $key
     * @param $val
     * @return bool true - write successful, false - write failed.
     *
     * @NotThreadSafe double-check absents between file_put_contents() and rename()
     */
    private static function write($key, $val): bool
    {
        self::ensureDir();
        $tmp = self::getDir($key) . '.' . time() . '.' . uniqid();
        if (!file_put_contents($tmp, '<?php $val = ' . $val . ';', LOCK_EX)) {
            return false;
        }
        rename($tmp, self::getDir($key));
        return true;
    }

    /**
     * @param $key
     * @return null
     */
    private static function read($key)
    {
        @include self::getDir($key);
        return $val ?? null;
    }

    private static function ensureDir() {
        if (file_exists(self::PATH_PREFIX)) {
            return;
        }
        mkdir(self::PATH_PREFIX, 0777, true);
    }

    private static function getDir($file) : string {
        return self::PATH_PREFIX . $file;
    }
}
