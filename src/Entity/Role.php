<?php

namespace Programarivm\EasyAclBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Programarivm\EasyAclBundle\Repository\RoleRepository")
 * @ORM\Table(name="easy_acl_role")
 */
class Role
{
    const TYPE_ADMIN = 'Admin';
    const TYPE_BASIC = 'Basic';
    const TYPE_SUPERADMIN = 'Superadmin';

    // TODO:
    // add common role types
    // ...

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    public static function getChoices()
    {
        return (object) [
            'type' => [
                self::TYPE_ADMIN,
                self::TYPE_BASIC,
                self::TYPE_SUPERADMIN,
            ],
        ];
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }
}
