<?php

namespace Newcamd\Crypt;

use Newcamd\Byte;
use Newcamd\Crypt\Cipher\Mcrypt;
use Newcamd\Crypt\Cipher\OpenSSL;
use Newcamd\Crypt\Exception\CipherException;
use Newcamd\ServerMessage;
use Newcamd\ServerMessageFactory;

class Cipher
{
    const DES_BLOCK_SIZE = 8;
    /**
     * @var Key
     */
    protected $key;
    protected $cipher;
    protected $message;


    public function __construct()
    {
        if (function_exists("openssl_encrypt")) {
            $this->cipher = new OpenSSL();
        } elseif (function_exists("mcrypt_encrypt")) {
            $this->cipher = new Mcrypt();
        } else {
            throw new CipherException('Can\'t find any cipher module (OpenSSL or Mcrypt)', 0);
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

    private function addChecksum()
    {
        $checksum = "\0";

        for ($i = 0; $i < $this->getMessage()->getLength(); $i++) {
            $checksum ^= $this->getMessage()->getOne($i)->get();
        }
        $this->getMessage()->append($checksum);

        return $this;
    }

    private function checkChecksum(Byte $message){
        $checksum = "\0";
        for ($i = 0; $i<$message->getLength(); $i++) {
            $checksum ^= $message->getOne($i)->get();
        }

        return $checksum == "\0";
    }

    private function addPad()
    {
        $noPadBytes = (self::DES_BLOCK_SIZE - (($this->getMessage()->getLength() + 1) % self::DES_BLOCK_SIZE))
            % self::DES_BLOCK_SIZE;
        $this->getMessage()->append($this->getRandom($noPadBytes));

        return $this;
    }

    private function prepare()
    {
        $len = $this->getMessage()->getLength();
//        if ($len < 3 || $len + 12 > CWS_NETMSGSIZE) return -1;

        //NetBuf Header
        $netbuf = new Byte(10);

        // Todo: Obsługa sid caid...
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
        $this->getMessage()->setOneAscii(($this->getMessage()->getOne(1)->ord() & 0xf0) | ((($len - 3) >> 8) & 0x0f), 1)
            ->setOneAscii(($len - 3) & 0xff, 2)
            ->prepend($netbuf);

        return $this;
    }

    public function encrypt()
    {
        if (!$this->getMessage()) {
            throw new CipherException('Lack of message. Use setMessage() first.', 1);
        }
        if (!$this->getKey()) {
            throw new CipherException('Lack of encrypt key. Use setKey() first.', 2);
        }

        $this->prepare()
            ->addPad()
            ->addChecksum();

        $ivec = $this->getRandom(self::DES_BLOCK_SIZE);
        $this->cipher->setIv($ivec);

        $crypt = new ServerMessage\Crypt();
        $crypt->set('');

        for ($i = 0; $i<$this->getMessage()->getLength(); $i += self::DES_BLOCK_SIZE) {
            $range = $this->getMessage()->getRange($i, self::DES_BLOCK_SIZE);

            $des = $this->cipher->encrypt($range);
            $crypt->append($des);
            $this->cipher->setIv($des);
        }

        $crypt->append($ivec);

        return $crypt;
    }

    public function decrypt()
    {
        if (!$this->getMessage() instanceof ServerMessage\Crypt) {
            throw new CipherException(
                'Can\'t decrypt '.get_class($this->getMessage()).'. Only ServerMessage\Crypt is allowed.',
                3
            );
        }

        $this->cipher->setIv($this->getMessage()->getRange($this->getMessage()->getLength()-8, 8));
        $decrypted = new Byte();
        $decrypted->set('');

        for ($i = 0; $i<$this->getMessage()->getLength()-8; $i += self::DES_BLOCK_SIZE) {
            $range = $this->getMessage()->getRange($i, self::DES_BLOCK_SIZE);

            $decrypted->append($this->cipher->decrypt($range));
            $this->cipher->setIv($range);
        }

        if (!$this->checkChecksum($decrypted)) {
            throw new CipherException('Checksum failed. Possible incorrect 3DES key', 4);
        }

        // Todo: Obsługa sid caid, aktualnie wycinane
        $decrypted = $decrypted->getRange(10);

        return ServerMessageFactory::create($decrypted);
    }

    public function getRandom($length)
    {
        $length = (int)$length;

        $buffer = new Byte($length);
        $buffer->set($this->cipher->getRandom($length));

        return $buffer;
    }

    /**
     * @return ServerMessage
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param ServerMessage $message
     * @return $this
     */
    public function setMessage(ServerMessage $message)
    {
        $this->message = $message;

        return $this;
    }
}
