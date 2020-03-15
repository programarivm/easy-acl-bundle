<?php

namespace Programarivm\EasyAclBundle\Repository;

use Programarivm\EasyAclBundle\Entity\Identity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class IdentityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Identity::class);
    }

    public function isAllowed($user, $routename): ?bool
    {
        $identities = $this->findBy(['user' => $user]);
        foreach ($identities as $identity) {
            $isAllowed = $this->getEntityManager()
                            ->getRepository('EasyAclBundle:Permission')
                            ->isAllowed($identity->getRole()->getName(), $routename);
            if ($isAllowed) {
                return true;
            }
        }

        return false;
    }

    public function deleteAll()
    {
        $dql = 'DELETE FROM Programarivm\EasyAclBundle\Entity\Identity';
        $query = $this->getEntityManager()
                    ->createQuery($dql);

        return $query->execute();
    }
}
