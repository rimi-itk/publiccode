<?php

namespace App\EventSubscriber;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\PreFlushEventArgs;

/**
 * @see https://stackoverflow.com/a/45846420
 */
class EntitySubscriber implements EventSubscriber
{
    public function getSubscribedEvents()
    {
        return [
            'preFlush',
        ];
    }

    public function preFlush(PreFlushEventArgs $args)
    {
        $entityManager = $args->getEntityManager();
        $entityManager->clear();
    }
}
