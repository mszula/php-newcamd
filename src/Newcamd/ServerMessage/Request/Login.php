<?php

namespace Newcamd\ServerMessage\Request;

use Newcamd\ServerMessage;
use Newcamd\ServerMessageInterface;

class Login extends ServerMessage implements ServerMessageInterface
{
    const MESSAGE_ID = "\xe0";
    const PASSWORD_SALT = '$1$abcdefgh$';

    protected $login = null;
    protected $crypt_password = null;

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
        $this->setBytes();

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
        $this->crypt_password = crypt($password, self::PASSWORD_SALT);
        $this->setBytes();

        return $this;
    }

    private function setBytes()
    {
        $this->set(self::MESSAGE_ID."\0\0".$this->getLogin()."\0".$this->getPassword()."\0");
    }
}
