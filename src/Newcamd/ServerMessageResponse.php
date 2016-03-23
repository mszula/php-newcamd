<?php

namespace Newcamd;


abstract class ServerMessageResponse
{
    protected $message;

    /**
     * ServerMessageResponse constructor.
     * @param $message
     */
    public function __construct($message=null)
    {
        if ($message) {
            $this->setMessage($message);
        }
    }

    /**
     * @return Byte
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param mixed $message
     * @return $this
     */
    public function setMessage($message)
    {
        $this->message = ByteFactory::create($message);
        
        return $this;
    }
    
    
}