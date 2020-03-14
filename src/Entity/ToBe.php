<?php

namespace Programarivm\EasyAclBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Programarivm\EasyAclBundle\Repository\ToBeRepository")
 * @ORM\Table(name="easy_acl_to_be")
 */
class ToBe
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="Programarivm\EasyAclBundle\Entity\Role")
     */
    private $role;
}
