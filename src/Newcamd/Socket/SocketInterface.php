<?php

namespace Newcamd\Socket;

use Newcamd\ServerMessage\Crypt;

interface SocketInterface
{
    public function connect($host, $port);
    public function receive($len = null);
    public function send(Crypt $message);
    public function isConnected();
}
