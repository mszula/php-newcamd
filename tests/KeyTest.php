<?php


use Newcamd\Crypt\Key;

class KeyTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Key
     */
    protected $key;

    public function setUp()
    {
        $this->key = new Key(\Newcamd\ByteFactory::create('f9a5d4a4ae00478b66d8d33610f2'));
    }

    public function testGet()
    {
        $this->assertEquals('f9a5d4a4ae00478b66d8d33610f2', bin2hex($this->key->get()));
    }

    public function testSetDesKey()
    {
        $this->key->setDesKey(\Newcamd\ByteFactory::create('0102030405060708091011121314'));

        $this->assertEquals('f852f4f40a58188082b6f21822200ecc', bin2hex($this->key->get()));
    }

    public function testGetLength()
    {
        $this->assertEquals(14, $this->key->getLength());
    }

    public function testGetLengthSpread()
    {
        $this->key->setDesKey(\Newcamd\ByteFactory::create('0102030405060708091011121314'));

        $this->assertEquals(16, $this->key->getLength());
    }

    public function testGetRange()
    {
        $this->assertEquals('d4a4ae', $this->key->getRange(2, 3)->hex());
    }
}
