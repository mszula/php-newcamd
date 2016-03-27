<?php

namespace Newcamd\ServerMessage\Request;

use Newcamd\ServerMessage;
use Newcamd\ServerMessageInterface;

class Card extends ServerMessage implements ServerMessageInterface
{
    const MESSAGE_ID = "\xe3";

    public function __construct($length = 0)
    {
        parent::__construct($length);

        $this->set(self::MESSAGE_ID."\0\0");
    }

}
