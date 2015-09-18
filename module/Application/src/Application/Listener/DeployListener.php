<?php

namespace Application\Listener;

use Zend\EventManager\EventInterface;
use Zend\Cache\Storage\FlushableInterface;

class DeployListener
{
    public static function flushCache(EventInterface $e)
    {
        $target = $e->getTarget();

        $cache  = $target->getServiceLocator()->get('Application\Cache');

        if ($cache instanceof FlushableInterface) {
            $cache->flush();
        }
    }
}
