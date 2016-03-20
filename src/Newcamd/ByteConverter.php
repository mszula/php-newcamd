<?php
/**
 * Created by PhpStorm.
 * User: Mateusz
 * Date: 2016-03-19
 * Time: 21:50
 */

namespace Newcamd;


class ByteConverter
{
    public static function Int8Bit($byte)
    {
        return pack('C*', $byte & 0xff);
    }

    public static function Int16Bit($byte)
    {
        return pack('n*', $byte & 0xffff);
    }
}