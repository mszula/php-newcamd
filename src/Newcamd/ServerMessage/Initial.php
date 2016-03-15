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
    /**
     * @var Byte
     */
    protected $bytes14;

    public function isValid()
    {
        return ($this->getLength() == 14);
    }

    public function get14ByteKey()
    {
        return $this->getMessage();
    }

    public function getMessage()
    {
        return $this->bytes14;
    }

    public function setMessage($message)
    {
        $this->bytes14 = ByteFactory::create($message);
    }
}
