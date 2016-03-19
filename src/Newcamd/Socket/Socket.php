<?php

namespace Newcamd\Socket;

use Newcamd\ServerMessage;
use Newcamd\Socket\Exception\SocketException;

class Socket
{
    protected $handle;

    public function __construct()
    {
        $this->socket = @socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        if (!$this->socket) {
            $this->error();
        }
    }

    public function connect($host, $port)
    {
        if (!@socket_connect($this->socket, $host, $port)) {
            $this->error();
        }
        return $this;
    }

    public function receive($len = 4092)
    {
        if (@socket_recv($this->socket, $data, $len, 0) === false) {
            $this->error();
        }

        return $data;
    }

    public function send(ServerMessage\Crypt $message)
    {
        if (!@socket_send($this->socket, $message, strlen($message), 0)) {
            $this->error();
        }

        return $this;
    }
    
    protected function error()
    {
        $error_no = socket_last_error();
        throw new SocketException(socket_strerror($error_no), $error_no);
    }
}
