<?php

namespace Programarivm\EasyAclBundle\Repository;

use Programarivm\EasyAclBundle\Entity\ToBe;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class ToBeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ToBe::class);
    }

    public function deleteAll()
    {
        $dql = 'DELETE FROM Programarivm\EasyAclBundle\Entity\ToBe';
        $query = $this->getEntityManager()
                    ->createQuery($dql);

        return $query->execute();
    }
}
