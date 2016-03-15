<?php
/**
 * Created by PhpStorm.
 * User: Mateusz
 * Date: 2016-03-10
 * Time: 11:24
 */

namespace Newcamd;


class Config
{
    private $username;
    private $password;
    private $des_key;
    private $host;
    private $port;

    /**
     * @return mixed
     */
    public function getDesKey()
    {
        return $this->des_key;
    }

    /**
     * @param mixed $des_key
     */
    public function setDesKey($des_key)
    {
        $this->des_key = ByteFactory::create($des_key);

        return $this;
    }

    /**
     * @param mixed $port
     */
    public function setPort($port)
    {
        $this->port = $port;

        return $this;
    }

    /**
     * @return int
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $username
     * @return $this
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return $this
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return string
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * @param string $host
     * @return $this
     */
    public function setHost($host)
    {
        $this->host = $host;

        return $this;
    }

}