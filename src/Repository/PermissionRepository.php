<?php

namespace Programarivm\EasyAclBundle\Repository;

use Programarivm\EasyAclBundle\Entity\Permission;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class PermissionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Permission::class);
    }

    public function isAllowed(string $rolename, string $routename): ?bool
    {
        $qb = $this->createQueryBuilder('p');

        return (bool) $qb
            ->where('p.rolename = :rolename')
            ->andWhere('p.routename = :routename')
            ->setParameters([
                'rolename' => $rolename,
                'routename' => $routename,
            ])
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function deleteAll()
    {
        $dql = 'DELETE FROM Programarivm\EasyAclBundle\Entity\Permission';
        $query = $this->getEntityManager()
                    ->createQuery($dql);

        return $query->execute();
    }
}
