<?php

namespace Programarivm\EasyAclBundle;

use Programarivm\EasyAclBundle\DependencyInjection\ProgramarivmEasyAclExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class EasyAclBundle extends Bundle
{
    public function getContainerExtension()
    {
        if (null === $this->extension) {
            $this->extension = new ProgramarivmEasyAclExtension();
        }

        return $this->extension;
    }
}
