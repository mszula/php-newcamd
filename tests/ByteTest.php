<?php
use Newcamd\Byte;


/**
 * Created by PhpStorm.
 * User: Mateusz
 * Date: 2016-03-09
 * Time: 00:07
 */
class ByteTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Byte
     */
    private $byte;
    
    public function setUp()
    {
        $this->byte = new Byte(0);
        $this->byte->set('t')
            ->setOne('e', 1)
            ->prepend('Ma')
            ->setOneAscii(117, 4)
            ->append('sz');
    }

    public function testGet()
    {
        $this->assertEquals("Mateusz", $this->byte->get());
    }

    public function testGetLength()
    {
        $this->assertEquals(7, $this->byte->getLength());
    }

    public function testSetLength()
    {
        $this->byte->setLength(8);
        $this->assertEquals("Mateusz\0", $this->byte->get());
        $this->assertEquals(8, $this->byte->getLength());
    }

    public function testGetOne()
    {
        $one = $this->byte->getOne(1);

        $this->assertInstanceOf('Newcamd\Byte', $one);
        $this->assertEquals('a', $one->get());
    }

    /*
     * @depends testGetOne
     */
    public function testGetOneOrd()
    {
        $this->assertEquals(97, $this->byte->getOne(1)->ord());
    }

    /*
     * @depends testGetOne
     */
    public function testGetOneHex()
    {
        $this->assertEquals(61, $this->byte->getOne(1)->hex());
    }

    /*
     * @depends testGetOne
     */
    public function testGetOneDec()
    {
        $this->assertEquals(97, $this->byte->getOne(1)->dec());
    }

    public function testGetRange()
    {
        $one = $this->byte->getRange(2, 2);

        $this->assertInstanceOf('Newcamd\Byte', $one);
        $this->assertEquals('te', $one->get());
    }

}
