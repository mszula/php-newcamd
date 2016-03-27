<?php

namespace Newcamd\Socket;

use Newcamd\ByteConverter;
use Newcamd\ServerMessage;
use Newcamd\ServerMessageFactory;
use Newcamd\Socket\Exception\SocketException;

class Socket implements SocketInterface
{
    protected $socket;
    protected $connected = false;

    public function __construct()
    {
        $this->socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        if (!$this->socket) {
            $this->error();
        }
    }

    public function connect($host, $port)
    {
        if (!socket_connect($this->socket, $host, $port)) {
            $this->error();
        }
        $this->connected = true;
        return $this;
    }

    public function receive($len = null)
    {
        if (!$len) {
            $len = $this->receive(2);
        }
        if ($len instanceof ServerMessage\Response\DataLength) {
            $len = $len->getLength();
        }
        
        if (socket_recv($this->socket, $data, $len, MSG_WAITALL) === false) {
            $this->error();
        }
        if (!$this->checkLength($data, $len)) {
            throw new SocketException('Read error '.$len.' bytes from server.', -1);
        }

        return ServerMessageFactory::create($data);
    }

    public function send(ServerMessage\Crypt $message)
    {
        $message->prepend(ByteConverter::IntSixteenBits($message->getLength()));

        if (!socket_send($this->socket, $message, strlen($message), 0)) {
            $this->error();
        }

        return $this;
    }
    
    public function isConnected()
    {
        return $this->connected;
    }
    
    protected function error()
    {
        $error_no = socket_last_error();
        throw new SocketException(socket_strerror($error_no), $error_no);
    }

    protected function checkLength($data, $len)
    {
        return (strlen($data) == $len);
    }
}
