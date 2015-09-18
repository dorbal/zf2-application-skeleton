<?php

namespace ApplicationTest;

class ServiceTest extends \PHPUnit_Framework_TestCase
{
    private $sm;

    protected function setUp()
    {
        $this->sm = Bootstrap::getServiceManager();
    }

    public function testExists()
    {
        $this->assertTrue($this->sm->has('Application\Cache'));
        $this->assertTrue($this->sm->has('Application\Password'));
        $this->assertTrue($this->sm->has('Zend\Db\Adapter\Adapter'));
    }

    /**
     * @depends testExists
     */
    public function testIsShared()
    {
        $this->assertTrue($this->sm->isShared('Application\Password'));
        $this->assertTrue($this->sm->isShared('Zend\Db\Adapter\Adapter'));
    }

    /**
     * @depends testExists
     */
    public function testIsNotShared()
    {
        $this->assertFalse($this->sm->isShared('Application\Cache'));
    }
}
