<?php

namespace Newcamd\ServerMessage;

use Newcamd\ByteFactory;
use Newcamd\ServerMessage;
use Newcamd\ServerMessageInterface;

/**
 * Created by PhpStorm.
 * User: Mateusz
 * Date: 2016-03-09
 * Time: 00:35
 */
class Login extends ServerMessage implements ServerMessageInterface
{
    const MESSAGE_ID = "\xe0";
    const PASSWORD_SALT = '$1$abcdefgh$';

    protected $login = null;
    protected $crypt_password = null;

    public function getMessage()
    {
        return ByteFactory::create(self::MESSAGE_ID."\0\0".$this->getLogin()."\0".$this->getPassword()."\0");
    }

    public function setMessage($message)
    {
        $bytes = ByteFactory::create($message);
    }

    public function isValid()
    {
        return $this->getLogin() && $this->getPassword();
    }

    /**
     * @return string
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * @param string $login
     */
    public function setLogin($login)
    {
        $this->login = $login;

        return $this;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->crypt_password;
    }

    /**
     * @param string $crypt_password
     */
    public function setPassword($password)
    {
        $this->crypt_password = crypt($password, '$1$abcdefgh$');

        return $this;
    }
}
