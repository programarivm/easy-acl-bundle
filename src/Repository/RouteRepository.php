<?php

namespace Programarivm\EasyAclBundle\Repository;

use Programarivm\EasyAclBundle\Entity\Route;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class RouteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Route::class);
    }

    public function deleteAll()
    {
        $dql = 'DELETE FROM Programarivm\EasyAclBundle\Entity\Route';
        $query = $this->getEntityManager()
                    ->createQuery($dql);

        return $query->execute();
    }
}
