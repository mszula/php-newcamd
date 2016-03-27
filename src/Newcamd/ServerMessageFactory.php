<?php

namespace Newcamd;

class ServerMessageFactory
{

    /**
     * @param string|Byte $message
     * @return bool|ServerMessage\Response\CardData|ServerMessage\Response\DataLength|ServerMessage\Response\Initial|ServerMessage\Response\LoginSuccess
     */
    public static function create($message)
    {
        if ($message instanceof Byte) {
            $message = $message->get();
        }
        if (strlen($message) == 14) {
            return (new ServerMessage\Response\Initial($message));
        }
        if (strlen($message) == 2) {
            return (new ServerMessage\Response\DataLength($message));
        }
        if ($message[0] == ServerMessage\Response\LoginSuccess::MESSAGE_ID) {
            return (new ServerMessage\Response\LoginSuccess($message));
        }
        if ($message[0] == ServerMessage\Response\Card::MESSAGE_ID) {
            return (new ServerMessage\Response\Card($message));
        }
        if (($message % 8) == 0) {
            return (new ServerMessage\Crypt())->set($message);
        }

        return false;
    }
}
