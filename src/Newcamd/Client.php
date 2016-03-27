<?php

namespace Newcamd;


use Newcamd\Crypt\Cipher;
use Newcamd\Crypt\Key;
use Newcamd\Exception\LoginException;
use Newcamd\ServerMessage\Request\Card;
use Newcamd\ServerMessage\Request\Login;
use Newcamd\Socket\Exception\SocketException;
use Newcamd\Socket\Fsock;
use Newcamd\Socket\Socket;
use Newcamd\Socket\SocketInterface;

class Client
{
    /**
     * @var Config
     */
    protected $config;
    /**
     * @var SocketInterface
     */
    protected $socket;
    /**
     * @var Cipher
     */
    protected $cipher;
    /**
     * @var ServerMessage\Response\Card
     */
    protected $cardData = null;
    protected $login = null;

    /**
     * Newcamd constructor.
     * @param $config
     */
    public function __construct(Config $config, SocketInterface $socket = null)
    {
        $this->config = $config;

        $this->cipher = new Cipher();

        if ($socket) {
            $this->socket = $socket;
        } else {
            if (function_exists("socket_connect")) {
                $this->socket = new Socket();
            } elseif (function_exists("fsockopen")) {
                $this->socket = new Fsock();
            } else {
                throw new SocketException('Can\'t find any socket module', 0);
            }
        }
    }

    public function connect()
    {
        $this->socket->connect($this->config->getHost(), $this->config->getPort());
        $initial = $this->receive(14);
        $this->setLoginKey($initial);

        return $this;
    }

    public function login()
    {
        $login_message = new Login();
        $login_message->setLogin($this->config->getUsername())->setPassword($this->config->getPassword());
        $this->socket->send(
            $this->cipher->setMessage($login_message)
                ->encrypt()
        );
        $this->login = $this->receive();

        if (!$this->isLogged()) {
            throw new LoginException('Login failed!', 1);
        }

        $this->setSessionKey($login_message);
        
        return $this;
    }
    
    public function getCaid()
    {
        if (!$this->cardData) {
            $this->refreshCard();
        }

        return $this->cardData->getCaid();
    }

    public function getProviders()
    {
        if (!$this->cardData) {
            $this->refreshCard();
        }

        return $this->cardData->getProviders();
    }
    
    private function setLoginKey(ServerMessage\Response\Initial $initial)
    {
        $login_key = new Key($initial->get14ByteKey());
        $login_key->setDesKey($this->config->getDesKey());
        $this->cipher->setKey($login_key);

        return $this;
    }

    private function setSessionKey(ServerMessage\Request\Login $login)
    {
        $session_key = new Key($this->config->getDesKey());
        $session_key->setDesKey(ByteFactory::create($login->getPassword()));
        $this->cipher->setKey($session_key);

        return $this;
    }

    private function receive($len = null)
    {
        $server_message = $this->socket->receive($len);
        if ($server_message instanceof ServerMessage\Crypt) {
            $server_message = $this->cipher->setMessage($server_message)->decrypt();
        }

        return $server_message;
    }

    private function refreshCard()
    {
        if (!$this->isLogged()) {
            throw new LoginException('You should login() first.', 2);
        }

        $this->socket->send(
            $this->cipher->setMessage(new Card())
                ->encrypt()
        );

        $message = $this->receive();
        if (!$message instanceof ServerMessage\Response\Card) {

        }
        $this->cardData = $message;

        return $this;
    }

    public function isConnected()
    {
        return $this->socket->isConnected();
    }

    public function isLogged()
    {
        return ($this->login instanceof ServerMessage\Response\LoginSuccess);
    }

}