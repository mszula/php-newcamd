<?php

namespace Newcamd;

class ServerMessageFactory
{
    public static function create($message)
    {
        if (strlen($message) == 14) {
            return (new ServerMessage\Initial(14))->set($message);
        }
        if ($message[0] == "\0" && ((strlen($message)-2) % 8) == 0) {
            return (new ServerMessage\Crypt())->set($message);
        }

        return false;
    }
}
