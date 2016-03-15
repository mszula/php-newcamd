<?php

namespace Newcamd;

class ServerMessageFactory
{
    public static function create($message)
    {
        if (strlen($message) == 14) {
            return new ServerMessage\Initial($message);
        }

        return false;
    }
}
