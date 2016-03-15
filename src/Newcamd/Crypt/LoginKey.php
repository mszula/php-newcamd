<?php
/**
 * Created by PhpStorm.
 * User: Mateusz
 * Date: 2016-03-10
 * Time: 21:45
 */

namespace Newcamd\Crypt;


use Newcamd\Byte;

class LoginKey extends Key
{

    public function setDesKey(Byte $key) {
        $this->xorKey($key);
        $this->spread();

        return $this;
    }

    private function spread()
    {
        $spread = new Byte(16);

        for ($i=0; $i<16; $i++) {
            if ($i == 0) {
                $spread->setOneAscii($this->byte->getOne($i)->ord() & 0xfe, $i);
            } else if ($i >= 1 && $i <= 6) {
                $spread->setOneAscii((($this->byte->getOne($i-1)->ord() << (8-$i)) | ($this->byte->getOne($i)->ord() >> $i)) & 0xfe, $i);
            } else if ($i == 7) {
                $spread->setOneAscii($this->byte->getOne($i-1)->ord() << 1, $i);
            } else if ($i == 8) {
                $spread->setOneAscii($this->byte->getOne($i-1)->ord() & 0xfe, $i);
            } else if ($i >= 9 && $i <= 14) {
                $spread->setOneAscii((($this->byte->getOne($i-2)->ord() << (16-$i)) | ($this->byte->getOne($i-1)->ord() >> ($i-8))) & 0xfe, $i);
            } else if ($i == 15) {
                $spread->setOneAscii($this->byte->getOne($i-2)->ord() << 1, $i);
            }
        }

//        $spread[ 0] = $this->byte->getOne(0)->ord() & 0xfe;
//        $spread[ 1] = (($this->byte->getOne(0)->ord() << 7) | ($this->byte->getOne(1)->ord() >> 1)) & 0xfe;
//        $spread[ 2] = (($this->byte->getOne(1)->ord() << 6) | ($this->byte->getOne(2)->ord() >> 2)) & 0xfe;
//        $spread[ 3] = (($this->byte->getOne(2)->ord() << 5) | ($this->byte->getOne(3)->ord() >> 3)) & 0xfe;
//        $spread[ 4] = (($this->byte->getOne(3)->ord() << 4) | ($this->byte->getOne(4)->ord() >> 4)) & 0xfe;
//        $spread[ 5] = (($this->byte->getOne(4)->ord() << 3) | ($this->byte->getOne(5)->ord() >> 5)) & 0xfe;
//        $spread[ 6] = (($this->byte->getOne(5)->ord() << 2) | ($this->byte->getOne(6)->ord() >> 6)) & 0xfe;
//        $spread[ 7] = $this->byte->getOne(6)->ord() << 1;
//        $spread[ 8] = $this->byte->getOne(7)->ord() & 0xfe;
//        $spread[ 9] = (($this->byte->getOne(7)->ord() << 7) | ($this->byte->getOne(8)->ord() >> 1)) & 0xfe;
//        $spread[10] = (($this->byte->getOne(8)->ord() << 6) | ($this->byte->getOne(9)->ord() >> 2)) & 0xfe;
//        $spread[11] = (($this->byte->getOne(9)->ord() << 5) | ($this->byte->getOne(10)->ord() >> 3)) & 0xfe;
//        $spread[12] = (($this->byte->getOne(10)->ord() << 4) | ($this->byte->getOne(11)->ord() >> 4)) & 0xfe;
//        $spread[13] = (($this->byte->getOne(11)->ord() << 3) | ($this->byte->getOne(12)->ord() >> 5)) & 0xfe;
//        $spread[14] = (($this->byte->getOne(12)->ord() << 2) | ($this->byte->getOne(13)->ord() >> 6)) & 0xfe;
//        $spread[15] = $this->byte->getOne(13)->ord() << 1;

        $this->byte->setLength($spread->getLength())->set($spread);

        return $this;

    }


}