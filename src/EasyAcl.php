<?php

namespace Programarivm\EasyAclBundle;

class EasyAcl
{
    private $providers;

    private $roles;

    private $access;

    public function __construct(array $providers, array $access = [])
    {
        $this->providers = $providers;
        $this->roles = [];
        $this->access = $access;
    }

    public function getRoles()
    {
        // TODO

        return $this->roles;
    }

    public function getAccess()
    {
        return $this->access;
    }
}
