<?php
/**
 * Created by PhpStorm.
 * User: Mateusz
 * Date: 2016-03-16
 * Time: 14:11
 */

namespace Newcamd\Crypt\Cipher;


use Newcamd\Byte;
use Newcamd\Crypt\Key;

abstract class Generic
{
    /**
     * @var Key
     */
    protected $key = null;
    /**
     * @var Byte
     */
    protected $iv = null;

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