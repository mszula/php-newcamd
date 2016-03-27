<?php

namespace Newcamd\ServerMessage\Response;

use Newcamd\ServerMessageInterface;
use Newcamd\ServerMessageResponse;

class LoginError extends ServerMessageResponse implements ServerMessageInterface
{
    const MESSAGE_ID = "\xe2";

    public function isLogin()
    {
        return false;
    }
}
