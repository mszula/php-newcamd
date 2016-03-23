<?php

namespace Newcamd;

class ServerMessageFactory
{

    public static function create($message)
    {
        if ($message instanceof Byte) {
            $message = $message->get();
        }
        if (strlen($message) == 14) {
            return (new ServerMessage\Response\Initial($message));
        }
        if ($message[0] == ServerMessage\Response\LoginSuccess::MESSAGE_ID) {
            return (new ServerMessage\Response\LoginSuccess($message));
        }
        if ($message[0] == ServerMessage\Response\CardData::MESSAGE_ID) {
            return (new ServerMessage\Response\CardData($message));
        }
        if (((strlen($message)-2) % 8) == 0) {
            return (new ServerMessage\Crypt())->set(substr($message, 2));
        }

        return false;
    }
}
