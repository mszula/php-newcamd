<?php
/**
 * Created by PhpStorm.
 * User: Mateusz
 * Date: 2016-03-15
 * Time: 00:02
 */

namespace Newcamd;


interface ServerMessageInterface
{
    public function getMessage();
    public function setMessage($message);
    public function isValid();
}