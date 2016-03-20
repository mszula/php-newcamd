<?php

namespace Newcamd\Crypt\Cipher;

use Newcamd\Byte;
use Newcamd\ByteFactory;
use Newcamd\Crypt\CipherInterface;
use Newcamd\Crypt\Key;
use Newcamd\ServerMessage;

class OpenSSL extends Generic implements CipherInterface
{
    public function encrypt(Byte $message)
    {
        return ByteFactory::create(
            openssl_encrypt(
                $message,
                'des-ede3-cbc',
                $this->getKey(),
                OPENSSL_RAW_DATA | OPENSSL_NO_PADDING,
                $this->getIv()
            )
        );
    }

    public function decrypt(Byte $message)
    {
        return ByteFactory::create(
            openssl_decrypt(
                $message,
                'des-ede3-cbc',
                $this->getKey(),
                OPENSSL_RAW_DATA | OPENSSL_NO_PADDING,
                $this->getIv()
            )
        );
    }

    public function getRandom($length)
    {
        $secure = true;
        return openssl_random_pseudo_bytes($length, $secure);
    }


}
