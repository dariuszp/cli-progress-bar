<?php

use Dariuszp\CliProgressBar;

class CliProgressBarTest extends PHPUnit_Framework_TestCase {

    public function testDummy() {
        $bar = new CliProgressBar();
        $this->assertTrue($bar->dummy());
    }

}