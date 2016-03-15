<?php
/**
 * Created by PhpStorm.
 * User: Mateusz
 * Date: 2016-03-09
 * Time: 00:37
 */

namespace Newcamd;


class ServerMessageFactory
{
    public static function create($message) {
        if (strlen($message) == 14) {
            return new ServerMessage\Initial($message);
        }

        return false;
    }
}