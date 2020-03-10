<?php

namespace Programarivm\EasyAclBundle;

class EasyAcl
{
    private $providers;

    private $roles;

    private $access;

    public function __construct(array $providers, array $roles = [], array $access = [])
    {
        $this->providers = $providers;
        $this->roles = $roles;
        $this->access = $access;
    }

    public function getRoles()
    {
        return $this->roles;
    }

    public function getAccess()
    {
        return $this->access;
    }
}
