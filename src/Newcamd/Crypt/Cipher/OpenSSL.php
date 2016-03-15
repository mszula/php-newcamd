<?php

namespace Newcamd\Crypt\Cipher;
use Newcamd\Crypt\CipherInterface;
use Newcamd\ServerMessage;

/**
 * Created by PhpStorm.
 * User: Mateusz
 * Date: 2016-03-14
 * Time: 23:49
 */
class OpenSSL implements CipherInterface
{
    public function encrypt(ServerMessage $message)
    {
        // TODO: Implement encrypt() method.
    }

    public function decrypt(ServerMessage\Crypt $message)
    {
        // TODO: Implement decrypt() method.
    }

}