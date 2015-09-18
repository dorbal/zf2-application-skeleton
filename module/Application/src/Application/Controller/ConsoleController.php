<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractConsoleController;

class ConsoleController extends AbstractConsoleController
{
    protected $eventIdentifier = 'Application';

    public function deployAction()
    {
        set_time_limit(0);
        $this->getEventManager()->trigger('DeployEvent', $this);
    }

    public function maintenanceAction()
    {
        set_time_limit(0);
        $this->getEventManager()->trigger('MaintenanceEvent', $this);
    }

    public function passwordAction()
    {
        $pwGen      = $this->getServiceLocator()->get('Application\Password');
        $password   = $this->getRequest()->getParam('password');

        return $pwGen->create($password).PHP_EOL;
    }
}
