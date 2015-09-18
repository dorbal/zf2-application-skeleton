<?php

namespace ApplicationTest;

use Zend\Mvc\MvcEvent;
use Zend\Stdlib\PriorityQueue;

class ListenerTest extends \PHPUnit_Framework_TestCase
{
    private $sm;

    protected function setUp()
    {
        $this->sm = Bootstrap::getServiceManager();
    }

    public function testFastcgiFinishRequest()
    {
        $app        = $this->sm->get('Application');
        $em         = $app->getEventManager();
        $listeners  = $em->getListeners(MvcEvent::EVENT_FINISH);

        $priority   = $this->getListenerPriority($listeners, 'fastcgi_finish_request');

        $this->assertNotNull($priority);
        $this->assertEquals(-20000, $priority);
    }

    public function testDeployListener()
    {
        $sem        = $this->sm->get('SharedEventManager');
        $listeners  = $sem->getListeners('Application', 'DeployEvent');

        $priority   = $this->getListenerPriority($listeners, 'Application\Listener\DeployListener::flushCache');

        $this->assertNotNull($priority);
        $this->assertEquals(-10000, $priority);
    }

    private function getListenerPriority($listeners, $findMe)
    {
        foreach ($listeners->toArray(PriorityQueue::EXTR_BOTH) as $v) {
            if ($v['data']->getCallback() === $findMe) {

                return $v['priority'];
            }
        }

        return null;
    }
}
