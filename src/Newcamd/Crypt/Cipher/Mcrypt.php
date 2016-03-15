<?php

namespace Newcamd\Crypt\Cipher;

use Newcamd\Byte;
use Newcamd\Crypt\CipherInterface;
use Newcamd\Crypt\Key;
use Newcamd\ServerMessage;

class Mcrypt implements CipherInterface
{
    protected $key = null;
    protected $iv = null;

    public function encrypt(Byte $message)
    {
        return mcrypt_encrypt(
            MCRYPT_3DES,
            $this->getKey()->get(),
            $message->get(),
            MCRYPT_MODE_CBC,
            $this->getIv()->get()
        );
    }

    public function decrypt(Byte $message)
    {
        // TODO: Implement decrypt() method.
    }

    public function getKey()
    {
        return $this->key;
    }

    public function getIv()
    {
        return $this->iv;
    }

    public function setKey(Key $key)
    {
        if ($key->getLength() == 16) {
            $byte = new Byte(24);
            $byte->set($key->get().substr($key->get(), 0, 8));
            $key = new Key($byte);
        }
        $this->key = $key;

        return $this;
    }

    public function setIv(Byte $iv)
    {
        $this->iv = $iv;

        return $this;
    }
}
