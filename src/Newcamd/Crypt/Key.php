<?php

namespace Newcamd\Crypt;

use Newcamd\Byte;

class Key
{
    /**
     * @var Byte
     */
    protected $byte;

    /**
     * Key constructor.
     * @param Byte $byte
     */
    public function __construct(Byte $byte)
    {
        $this->byte = $byte;
    }

    public function __toString()
    {
        return $this->get();
    }


    /**
     * @return string
     */
    public function get()
    {
        return $this->byte->get();
    }

    public function getLength()
    {
        return $this->byte->getLength();
    }

    public function xorKey(Byte $key2)
    {
        for ($i = 0; $i < $this->byte->getLength(); $i++) {
            $this->byte->setOne($this->byte->getOne($i)->get() ^ $key2->getOne($i)->get(), $i);
        }

        return $this;
    }
}
