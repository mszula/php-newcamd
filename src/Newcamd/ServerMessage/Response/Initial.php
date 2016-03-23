<?php

namespace Newcamd\ServerMessage\Response;

use Newcamd\ServerMessage;
use Newcamd\ServerMessageInterface;
use Newcamd\ServerMessageResponse;

class Initial extends ServerMessageResponse implements ServerMessageInterface
{
    
    public function get14ByteKey()
    {
        return $this->getMessage();
    }

}
