<?php

namespace Newcamd;

use Newcamd\Socket\Socket;

class Connect
{
    protected $config;
    protected $socket;

    /**
     * Connect constructor.
     * @param $config
     */
    public function __construct(Config $config)
    {
        $this->setConfig($config)
            ->setSocket(new Socket())
            ->connect();
    }

    public function connect()
    {
        $this->getSocket()->connect($this->getConfig()->getHost(), $this->getConfig()->getPort());

        return $this;
    }

    /**
     * @return ServerMessage
     */
    public function receive()
    {
        return ServerMessageFactory::create($this->getSocket()->receive());
    }

    public function send(ServerMessage\Crypt $message)
    {
        $message->prepend("\0\0");
        $message->setOneAscii(($message->getLength() - 2) >> 8, 0);
        $message->setOneAscii(($message->getLength() - 2) & 0xff, 1);

        echo $message->hex();

        return $this->getSocket()->send($message);
    }

    /**
     * @return Config
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @param Config $config
     */
    public function setConfig(Config $config)
    {
        $this->config = $config;

        return $this;
    }

    /**
     * @return Socket
     */
    public function getSocket()
    {
        return $this->socket;
    }

    /**
     * @param Socket $socket
     */
    public function setSocket($socket)
    {
        $this->socket = $socket;

        return $this;
    }
}
