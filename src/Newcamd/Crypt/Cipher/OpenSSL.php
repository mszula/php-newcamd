<?php

namespace Newcamd\Crypt\Cipher;

use Newcamd\Crypt\CipherInterface;
use Newcamd\ServerMessage;

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
