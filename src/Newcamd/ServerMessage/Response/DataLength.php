<?php

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
