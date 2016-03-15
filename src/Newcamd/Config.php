<?php

namespace Newcamd;

class Config
{
    private $username;
    private $password;
    private $des_key;
    private $host;
    private $port;

    public function getDesKey()
    {
        return $this->des_key;
    }

    public function setDesKey($des_key)
    {
        $this->des_key = ByteFactory::create($des_key);

        return $this;
    }

    public function setPort($port)
    {
        $this->port = $port;

        return $this;
    }

    public function getPort()
    {
        return $this->port;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    public function getHost()
    {
        return $this->host;
    }

    public function setHost($host)
    {
        $this->host = $host;

        return $this;
    }
}
