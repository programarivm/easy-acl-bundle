<?php

namespace Programarivm\EasyAclBundle\EventListener;

use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\LoadClassMetadataEventArgs;
use Doctrine\ORM\Events;
use Programarivm\EasyAclBundle\EasyAcl;

class IdentitySubscriber implements EventSubscriber
{
    private $easyAcl;

    public function __construct(EasyAcl $easyAcl)
    {
        $this->easyAcl = $easyAcl;
    }

    public function getSubscribedEvents()
    {
        return [
            Events::loadClassMetadata,
        ];
    }

    public function loadClassMetadata(LoadClassMetadataEventArgs $eventArgs)
    {
        $metadata = $eventArgs->getClassMetadata();

        if ($metadata->getName() !== 'Programarivm\EasyAclBundle\Entity\Identity') {
            return;
        }

        $namingStrategy = $eventArgs
            ->getEntityManager()
            ->getConfiguration()
            ->getNamingStrategy()
        ;

         $metadata->mapManyToOne([
             'fieldName' => 'user',
             'targetEntity' => $this->easyAcl->getTarget(),
         ]);
    }
}
