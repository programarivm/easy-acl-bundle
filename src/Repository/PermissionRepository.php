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

    public function isAllowed(string $role, string $route): ?bool
    {
        $qb = $this->createQueryBuilder('a');

        return (bool) $qb
            ->where('a.role = :role')
            ->andWhere('a.route = :route')
            ->setParameters([
                'role' => $role,
                'route' => $route,
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
