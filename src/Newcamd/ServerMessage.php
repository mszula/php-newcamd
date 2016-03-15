<?php
/**
 * Created by PhpStorm.
 * User: Mateusz
 * Date: 2016-03-09
 * Time: 00:34
 */

namespace Newcamd;


abstract class ServerMessage
{
    /**
     * @var Byte
     */
    protected $message;

    public function __construct($message=null)
    {
        if ($message) {
            $this->setMessage($message);
        }
    }

    function __toString()
    {
        return $this->getMessage()->get();
    }

    public function getLength()
    {
        return $this->message->getLength();
    }
}