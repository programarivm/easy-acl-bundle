<?php

namespace Programarivm\EasyAclBundle;

class EasyAcl
{
    private $providers;

    public function __construct(array $providers, array $roles = [])
    {
        $this->providers = $providers;
        $this->roles = $roles;
    }

    public function getRoles()
    {
        return $this->roles;
    }
}
