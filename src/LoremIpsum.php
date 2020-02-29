<?php

namespace Programarivm\EasyAclBundle;

class LoremIpsum
{
    private $unicornsAreReal;

    private $minSunshine;

    public function __construct(bool $unicornsAreReal = true, $minSunshine = 3)
    {
        $this->unicornsAreReal = $unicornsAreReal;
        $this->minSunshine = $minSunshine;
    }

    public function speak(): string
    {
        return 'lorem ipsum';
    }
}
