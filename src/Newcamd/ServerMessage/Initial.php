<?php

namespace Newcamd\ServerMessage;

use Newcamd\Byte;
use Newcamd\ByteFactory;
use Newcamd\ServerMessage;
use Newcamd\ServerMessageInterface;

/**
 * Created by PhpStorm.
 * User: Mateusz
 * Date: 2016-03-09
 * Time: 00:36
 */
class Initial extends ServerMessage implements ServerMessageInterface
{

    public function isValid()
    {
        return ($this->getLength() == 14);
    }

    public function get14ByteKey()
    {
        return $this->get();
    }

}
