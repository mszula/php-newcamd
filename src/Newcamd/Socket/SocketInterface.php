<?php

namespace Newcamd\Socket;

use Newcamd\ServerMessage\Crypt;

interface SocketInterface
{
    public function connect($host, $port);
    public function receive($len = 4092);
    public function send(Crypt $message);
}