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
        $this->byte->set('Mateusz');
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


}
