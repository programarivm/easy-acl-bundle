<?php

namespace Programarivm\EasyAclBundle\Repository;

use Programarivm\EasyAclBundle\Entity\Role;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class RoleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Role::class);
    }

    public function deleteAll()
    {
        $dql = 'DELETE FROM Programarivm\EasyAclBundle\Entity\Role';
        $query = $this->getEntityManager()
                    ->createQuery($dql);

        return $query->execute();
    }
}
