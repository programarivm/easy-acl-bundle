<?php

namespace Programarivm\EasyAclBundle;

class EasyAcl
{
    private $providers;

    private $target;

    private $permission;

    private $roles;

    public function __construct(array $providers, string $target, array $permission = [])
    {
        $this->providers = $providers;
        $this->roles = [];
        $this->target = $target;
        $this->permission = $permission;
        foreach ($this->permission as $item) {
            $this->roles[] = $item['role'];
        }
    }

    public function getTarget()
    {
        return $this->target;
    }

    public function getPermission()
    {
        return $this->permission;
    }

    public function getRoles()
    {
        return $this->roles;
    }
}
