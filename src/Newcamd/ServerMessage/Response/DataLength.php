<?php
/**
 * Created by PhpStorm.
 * User: Mateusz
 * Date: 2016-03-26
 * Time: 21:45
 */

namespace Newcamd\ServerMessage\Response;


use Newcamd\ServerMessageInterface;
use Newcamd\ServerMessageResponse;

class DataLength extends ServerMessageResponse implements ServerMessageInterface
{
    public function getLength()
    {
        return $this->getMessage()->dec();
    }
}