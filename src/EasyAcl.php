<?php

namespace Programarivm\EasyAclBundle;

class EasyAcl
{
    private $providers;

    private $roles;

    private $resources;

    public function __construct(array $providers, array $roles = [], array $resources = [])
    {
        $this->providers = $providers;
        $this->roles = $roles;
        $this->resources = $resources;
    }

    public function getRoles()
    {
        return $this->roles;
    }

    public function getResources()
    {
        return $this->resources;
    }
}
