<?php

namespace Newcamd;


class Client
{
    protected $config;
    protected $connect;
    protected $cipher;

    /**
     * Newcamd constructor.
     * @param $config
     */
    public function __construct(Config $config)
    {
        $this->config = $config;

        $this->cipher = new \Newcamd\Crypt\Cipher();
    }

    public function connect()
    {
        $this->connect = new Connect($this->config);
        $initial = $this->connect->receive();
        $login_key = new \Newcamd\Crypt\Key($initial);
        $login_key->setDesKey($this->config->getDesKey());
        $this->cipher->setKey($login_key);
        
        return $this;
    }

    public function login()
    {
        $login_message = new \Newcamd\ServerMessage\Request\Login();
        $login_message->setLogin($this->config->getUsername())->setPassword($this->config->getPassword());
        $this->connect->send(
            $this->cipher
                ->setMessage($login_message)
                ->encrypt()
        );
        $m = $this->connect->receive();
    }

}