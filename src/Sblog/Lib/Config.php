<?php
/**
 * not used now
 *
 */
namespace Sblog\Lib;

use Sblog\Lib\Core;

class Config extends Core
{
    static $configs;

    public static function read($name) {
        return self::$configs[$name];
    }

    public static function write($name, $value) {
        self::$configs[$name] = $value;
    }
}