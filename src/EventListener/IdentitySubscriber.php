<?php

namespace Programarivm\EasyAclBundle\EventListener;

use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\LoadClassMetadataEventArgs;
use Doctrine\ORM\Events;

class IdentitySubscriber implements EventSubscriber
{
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
             'targetEntity' => 'App\Entity\User',
         ]);

         // TODO
         // Replace App\Entity\User with a custom entity 
    }
}
