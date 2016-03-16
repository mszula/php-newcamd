<?php

namespace Newcamd\Crypt\Cipher;

use Newcamd\Byte;
use Newcamd\ByteFactory;
use Newcamd\Crypt\CipherInterface;
use Newcamd\ServerMessage;

class Mcrypt extends Generic implements CipherInterface
{
    public function encrypt(Byte $message)
    {
        return ByteFactory::create(mcrypt_encrypt(
            MCRYPT_3DES,
            $this->getKey(),
            $message,
            MCRYPT_MODE_CBC,
            $this->getIv()
        ));
    }

    public function decrypt(Byte $message)
    {
        return ByteFactory::create(mcrypt_decrypt(
            MCRYPT_3DES,
            $this->getKey()->get(),
            $message->get(),
            MCRYPT_MODE_CBC,
            $this->getIv()->get()
        ));
    }

    public function getRandom($length)
    {
        return mcrypt_create_iv($length, MCRYPT_DEV_URANDOM);
    }
}
