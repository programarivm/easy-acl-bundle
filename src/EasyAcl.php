<?php

namespace Programarivm\EasyAclBundle;

class EasyAcl
{
    private $providers;

    private $roles;

    private $routes;

    public function __construct(array $providers, array $roles = [], array $routes = [])
    {
        $this->providers = $providers;
        $this->roles = $roles;
        $this->routes = $routes;
    }

    public function getRoles()
    {
        return $this->roles;
    }

    public function getRoutes()
    {
        return $this->routes;
    }
}
