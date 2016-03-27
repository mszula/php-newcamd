<?php

namespace Newcamd;

class ByteConverter
{
    public static function IntEightBits($byte)
    {
        return pack('C*', $byte & 0xff);
    }

    public static function IntSixteenBits($byte)
    {
        return pack('n*', $byte & 0xffff);
    }
}
