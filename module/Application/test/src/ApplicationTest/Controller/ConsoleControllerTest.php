<?php

namespace ApplicationTest\Controller;

use Application\Controller\ConsoleController;
use ApplicationTest\Bootstrap;
use \Mockery as m;
use Zend\Test\PHPUnit\Controller\AbstractConsoleControllerTestCase;
use Zend\EventManager\Event;

class ConsoleControllerTest extends AbstractConsoleControllerTestCase
{
    protected function setUp()
    {
        $this->setApplicationConfig(
            Bootstrap::getServiceManager()->get('ApplicationConfig')
        );

        parent::setUp();

        $sem = $this->getApplication()->getEventManager()->getSharedManager();
        $sem->clearListeners('Application', 'DeployEvent');
    }

    protected function tearDown()
    {
        m::close();
    }

    /**
     * @covers Application\Controller\ConsoleController::deployAction
     */
    public function testDeployAction()
    {
        $testEventTarget = function ($e) {
            if ($e instanceof Event) {
                if ($e->getTarget() instanceof ConsoleController) {
                    return true;
                }
            }

            return false;
        };
        $mListener = m::mock()
            ->shouldReceive('do')
            ->with(m::on($testEventTarget))
            ->once()
            ->getMock()
        ;
        $sem = $this->getApplication()->getEventManager()->getSharedManager();
        $sem->attach('Application', 'DeployEvent', [$mListener, 'do']);

        $this->dispatch('deploy');

        $this->assertEquals(
            'Application\Controller\ConsoleController',
            $this->getControllerFullClassName()
        );

        $this->assertActionName('deploy');
    }

    /**
     * @covers Application\Controller\ConsoleController::MaintenanceAction
     */
    public function testMaintenanceAction()
    {
        $testEventTarget = function ($e) {
            if ($e instanceof Event) {
                if ($e->getTarget() instanceof ConsoleController) {
                    return true;
                }
            }

            return false;
        };
        $mListener = m::mock()
            ->shouldReceive('do')
            ->with(m::on($testEventTarget))
            ->once()
            ->getMock()
        ;
        $sem = $this->getApplication()->getEventManager()->getSharedManager();
        $sem->attach('Application', 'MaintenanceEvent', [$mListener, 'do']);

        $this->dispatch('maintenance');

        $this->assertEquals(
            'Application\Controller\ConsoleController',
            $this->getControllerFullClassName()
        );

        $this->assertActionName('maintenance');
    }

    /**
     * @covers Application\Controller\ConsoleController::passwordAction
     */
    public function testPasswordAction()
    {
        $mPassword = m::mock()
            ->shouldReceive('create')
            ->once()
            ->with('foo')
            ->andReturn('bar')
            ->getMock()
        ;

        $this
            ->getApplication()
            ->getServiceManager()
            ->setAllowOverride(true)
            ->setService('Application\Password', $mPassword)
        ;

        $this->dispatch('password foo');

        $this->assertEquals(
            'Application\Controller\ConsoleController',
            $this->getControllerFullClassName()
        );

        $this->assertActionName('password');

        $this->assertConsoleOutputContains('bar');
    }
}
