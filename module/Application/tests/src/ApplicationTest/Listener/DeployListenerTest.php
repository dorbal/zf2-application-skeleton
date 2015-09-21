<?php

namespace ApplicationTest\Listener;

use Application\Listener\DeployListener;

use \Mockery as m;

class DeployListenerTest extends \PHPUnit_Framework_TestCase
{
    protected function tearDown()
    {
        m::close();
    }

    /**
     * @covers Application\Listener\DeployListener::flushCache
     */
    public function testFlushCacheIfCacheNotFlushable()
    {
        $mCache = m::mock()->shouldNotReceive('flush')->getMock();

        $mEvent = $this->getMockEvent($mCache);

        DeployListener::flushCache($mEvent);
    }

    /**
     * @covers Application\Listener\DeployListener::flushCache
     */
    public function testFlushCacheIfCacheFlushable()
    {
        $mCache = m::mock('Zend\Cache\Storage\FlushableInterface')
            ->shouldReceive('flush')
            ->once()
            ->getMock()
        ;

        $mEvent = $this->getMockEvent($mCache);

        DeployListener::flushCache($mEvent);
    }

    private function getMockEvent($serviceReturn)
    {
        $mServiceLocator = m::mock('Zend\ServiceManager\ServiceLocatorInterface')
            ->shouldReceive('get')
            ->with('Application\Cache')
            ->andReturn($serviceReturn)
            ->getMock()
        ;

        $mController = m::mock(
            ['getServiceLocator' => $mServiceLocator]
        );

        $mEvent = m::mock(
            'Zend\EventManager\EventInterface',
            ['getTarget' => $mController]
        );

        return $mEvent;
    }
}
