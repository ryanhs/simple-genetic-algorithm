<?php

// require __DIR__ . '/../vendor/autoload.php';

class Test extends PHPUnit_Framework_TestCase
{
    public function test()
    {
        $stack = array();
        $this->assertEquals(0, count($stack));
    }
}
?>
