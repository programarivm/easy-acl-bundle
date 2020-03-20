<?php

namespace Programarivm\EasyAclBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Programarivm\EasyAclBundle\Repository\IdentityRepository")
 * @ORM\Table(name="easy_acl_identity")
 */
class Identity
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * To be dynamically set up.
     *
     * @see Programarivm\EasyAclBundle\EventListener\IdentitySubscriber
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="Programarivm\EasyAclBundle\Entity\Role")
     */
    private $role;

    public function getUser()
    {
        return $this->user;
    }

    public function setUser($user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getRole()
    {
        return $this->role;
    }

    public function setRole($role): self
    {
        $this->role = $role;

        return $this;
    }
}
