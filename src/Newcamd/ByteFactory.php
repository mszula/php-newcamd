<?php

namespace Newcamd;

class ByteFactory
{

    /**
     * @param $bytes
     * @return Byte
     */
    public static function create($bytes)
    {
        if (self::isHex($bytes)) {
            return self::createFromHex($bytes);
        }
        if (self::isBin($bytes)) {
            return self::createFromBin($bytes);
        }
        if ($bytes instanceof Byte) {
            return $bytes;
        }

        return self::createFromString($bytes);
    }

    private static function createFromString($bytes)
    {
        return (new Byte(strlen($bytes)))->set($bytes);
    }

    private static function createFromHex($bytes)
    {
        $bytes = self::strip(pack("H*", $bytes));

        return self::createFromString($bytes);
    }

    private static function createFromBin($bytes)
    {
        $bytes = self::strip(base_convert($bytes, 2, 16));

        return self::createFromHex($bytes);
    }

    private static function isHex($bytes)
    {
        return ctype_xdigit(self::strip($bytes));
    }

    private static function isBin($bytes)
    {
        return preg_match("/^[0-1]+$/", self::strip($bytes));
    }

    private static function strip($bytes)
    {
        return str_replace([' ', "\n", "\r"], '', $bytes);
    }
}
