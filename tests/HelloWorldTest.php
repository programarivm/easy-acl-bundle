<?php

namespace Programarivm\EasyAclBundle\Tests;

use Programarivm\EasyAclBundle\HelloWorld;
use PHPUnit\Framework\TestCase;

class HelloWorldTest extends TestCase
{
    /**
     * @test
     */
    public function signal()
    {
        $helloWorld = new HelloWorld([]);

        $this->assertStringStartsWith('Hello world!', $helloWorld->signal());
    }
}
