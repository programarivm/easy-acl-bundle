<?php

namespace Programarivm\EasyAclBundle\Tests;

use Programarivm\EasyAclBundle\EasyAcl;
use PHPUnit\Framework\TestCase;

class EasyAclTest extends TestCase
{
    /**
     * @test
     */
    public function signal()
    {
        $helloWorld = new EasyAcl([]);

        $this->assertStringStartsWith('Hello world!', $helloWorld->signal());
    }
}
