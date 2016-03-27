<?php

namespace Newcamd\ServerMessage\Response;

use Newcamd\ServerMessageInterface;
use Newcamd\ServerMessageResponse;

class LoginSuccess extends ServerMessageResponse implements ServerMessageInterface
{
    const MESSAGE_ID = "\xe1";
    
    public function isLogin()
    {
        return true;
    }

}
