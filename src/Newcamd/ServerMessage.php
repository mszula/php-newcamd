<?php

namespace Newcamd;

abstract class ServerMessage
{
    /**
     * @var Byte
     */
    protected $message;

    public function __construct($message = null)
    {
        if ($message) {
            $this->setMessage($message);
        }
    }

    public function __toString()
    {
        return $this->getMessage()->get();
    }

    public function getLength()
    {
        return $this->message->getLength();
    }
}
