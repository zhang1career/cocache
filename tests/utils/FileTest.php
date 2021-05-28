<?php

namespace phplab\cocache\tests\utils;

use phplab\cocache\utils\File;
use PHPUnit\Framework\TestCase;

class FileTest extends TestCase
{
    /****************************************
     * Unit Tests
     ****************************************/
    public function test_isValidPath()
    {
        $this->assertTrue(File::isValidPath('abc'));
        $this->assertTrue(File::isValidPath('def.txt'));
        $this->assertFalse(File::isValidPath('hij klm'));
        $this->assertTrue(File::isValidPath('o-p_q.exe'));
        $this->assertFalse(File::isValidPath('~rst'));
        $this->assertTrue(File::isValidPath('abc/-123/__klm.opq'));
    }
}