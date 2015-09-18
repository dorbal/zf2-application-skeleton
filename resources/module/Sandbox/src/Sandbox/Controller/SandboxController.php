<?php

namespace Sandbox\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Debug\Debug;
use Zend\Mvc\MvcEvent;

class SandboxController extends AbstractActionController
{
    public function indexAction()
    {
        ob_start();

        // sandbox start
        echo "foobar";

        $foo = 'bar';

        Debug::dump($foo, 'FOO');

        $sm = $this->getEventManager()->getSharedManager();
        $sm->attach(
            'Zend\Mvc\Application',
            MvcEvent::EVENT_FINISH,
            [$this, 'runAfterFastcgiFinishRequest'],
            -30000
        );
        // sandbox end

        return new ViewModel(['content' => ob_get_clean()]);
    }

    public function runAfterFastcgiFinishRequest()
    {

    }
}

