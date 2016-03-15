<?php
/**
 * Created by PhpStorm.
 * User: Mateusz
 * Date: 2016-03-08
 * Time: 13:29
 */

namespace Newcamd;


class Byte
{
    private $bytes = '';
    private $length = 0;

    /**
     * Byte constructor.
     * @param $length
     */
    public function __construct($length=0)
    {
        $this->setLength($length);
    }

    private function prepareBytes()
    {
        $this->set($this->get());

        return $this;
    }

    function __toString()
    {
        return $this->get();
    }

    public function get()
    {
        return $this->bytes;
    }

    public function getOne($position)
    {
        $self = new self(1);
        return $self->set($this->bytes[$position]);
    }

    public function setOne($byte, $position)
    {
        if ($byte instanceof Byte) {
            $byte = $byte->get();
        }

        $this->bytes[$position] = $byte;

        return $this;
    }

    public function setOneAscii($byte, $position)
    {
        return $this->setOne(chr($byte), $position);
    }

    public function set($bytes)
    {
        if ($bytes instanceof Byte) {
            $bytes = $bytes->get();
        }
        if (is_array($bytes)) {
            $bytes = implode('', $bytes);
        }
        $this->bytes = $bytes;

        $diff = $this->getLength() - strlen($bytes);
        if ($diff > 0) {
            for ($i=0; $i<$diff; $i++) {
                $this->bytes .= "\0";
            }
        } elseif ($diff < 0) {
            $this->bytes = substr($this->bytes, 0, $diff);
        }

        return $this;
    }

    public function append($bytes)
    {
        if ($bytes instanceof Byte) {
            $bytes = $bytes->get();
        }
        $new = $this->get().$bytes;
        if ($this->length > 0) {
            $this->setLength(strlen($new));
        }
        return $this->set($new);
    }

    public function prepend($bytes)
    {
        if ($bytes instanceof Byte) {
            $bytes = $bytes->get();
        }
        $new = $bytes.$this->get();
        if ($this->length > 0) {
            $this->setLength(strlen($new));
        }
        return $this->set($new);
    }

    /**
     * @return mixed
     */
    public function getLength()
    {
        return ($this->length > 0 ? $this->length : strlen($this->bytes));
    }

    public function setLength($length)
    {
        $this->length = $length;
        $this->prepareBytes();

        return $this;
    }

    public function hex()
    {
        return bin2hex($this->get());
    }

    public function dec()
    {
        return bindec($this->get());
    }

    public function ord()
    {
        return ord($this->get());
    }
}