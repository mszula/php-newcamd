<?php

namespace Newcamd\Crypt;

use Newcamd\Byte;
use Newcamd\ByteFactory;
use Newcamd\Crypt\Cipher\Mcrypt;
use Newcamd\ServerMessage;

class Cipher
{

    /**
     * @var Key
     */
    protected $key;
    protected $cipher;

    /**
     * Cipher constructor.
     * @param Key $key
     */
    public function __construct()
    {
        if (function_exists("mcrypt_encrypt")) {
            $this->cipher = new Mcrypt();
        }
    }


    public function getKey()
    {
        return $this->cipher->getKey();
    }

    public function setKey(Key $key)
    {
        $this->cipher->setKey($key);

        return $this;
    }

    private function addChecksum(Byte $message)
    {
        $checksum = "\0";

        for ($i = 2; $i < $message->getLength(); $i++) {
            $checksum ^= $message->getOne($i)->get();
        }

        return $message->append($checksum);
    }

    private function addPad(Byte $message)
    {
        $noPadBytes = (8 - (($message->getLength() - 1) % 8)) % 8;

        return $message->append($this->getRandom($noPadBytes));
    }

    private function prepare(Byte $message)
    {
        $len = $message->getLength();
//        if ($len < 3 || $len + 12 > CWS_NETMSGSIZE) return -1;

        //NetBuf Header
        $netbuf = new Byte(12);
        $cd = null;
        if ($cd) {
//        $netbuf->setOne(($cd->msgid >> 8) & 0xff, 2);
//		$netbuf[3] = cd->msgid & 0xff;
//		netbuf[4] = (cd->sid >> 8) & 0xff;
//		netbuf[5] = cd->sid & 0xff;
//		netbuf[6] = (cd->caid >> 8) & 0xff;
//		netbuf[7] = cd->caid & 0xff;
//		netbuf[8] = (cd->provid >> 16) & 0xff;
//		netbuf[9] = (cd->provid >> 8) & 0xff;
//		netbuf[10] = cd->provid & 0xff;
        }
        //set up data buffer length unsigned chars
        $message->setOneAscii(($message->getOne(1)->ord() & 0xf0) | ((($len - 3) >> 8) & 0x0f), 1)
            ->setOneAscii(($len - 3) & 0xff, 2)
            ->prepend($netbuf);

        return $message;
    }

    public function encrypt(ServerMessage $message)
    {

//        if (!$this->getKey()) {
//            throw new DESException('Lack of encrypt key. Use setKey() first.');
//        }

        $data = $message->getMessage();
        $data = $this->prepare($data);
        $data = $this->addPad($data);
        $data = $this->addChecksum($data);
        $data = $data->get();

        $ivec = $this->getRandom(8);
        $this->cipher->setIv($ivec);


        $first_ivec = $ivec;
        $header = substr($data, 0, 2);

        $pieces = str_split(substr($data, 2), 8);



        foreach ($pieces as $id => $p) {
            echo bin2hex($pieces[$id]).PHP_EOL;

            $pieces[$id] = $this->cipher->encrypt(ByteFactory::create($pieces[$id]));
//            $pieces[$id] = mcrypt_encrypt(
//                MCRYPT_3DES,
//                $this->getKey()->get().substr($this->getKey()->get(), 0, 8),
//                $pieces[$id],
//                MCRYPT_MODE_CBC,
//                $ivec
//            );
            echo bin2hex($pieces[$id]).PHP_EOL;
//            $ivec = $pieces[$id];
            $this->cipher->setIv(ByteFactory::create($pieces[$id]));
        }

        return $header.implode('', $pieces).$first_ivec;

    }

    public function getRandom($length)
    {
        $buffer = new Byte($length);
        $buffer->set(mcrypt_create_iv($length, MCRYPT_DEV_URANDOM));

        return $buffer;
    }
}
