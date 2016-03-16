<?php

namespace Newcamd\Crypt;

use Newcamd\Byte;

interface CipherInterface
{
    public function encrypt(Byte $message);
    public function decrypt(Byte $message);
    public function setKey(Key $key);
    public function getKey();
    public function setIv(Byte $iv);
    public function getIv();
    public function getRandom($length);
}
