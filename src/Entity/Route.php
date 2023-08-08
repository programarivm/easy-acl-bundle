<?php

namespace Programarivm\EasyAclBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Programarivm\EasyAclBundle\Repository\RouteRepository")
 * @ORM\Table(name="easy_acl_route")
 */
class Route
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $methods;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $path;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getMethods(): ?string
    {
        return $this->methods;
    }

    public function setMethods(string $methods): self
    {
        $this->methods = $methods;

        return $this;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(string $path): self
    {
        $this->path = $path;

        return $this;
    }
}
