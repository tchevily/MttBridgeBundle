<?php

namespace CanalTP\MttBridgeBundle\Security;

use CanalTP\Sam\Ecore\ApplicationManagerBundle\Security\AbstractBusinessModule;

class BusinessModule extends AbstractBusinessModule
{
    public function getId()
    {
        return 1;
    }

    public function getName()
    {
        return 'test';
    }

    public function getPermissions()
    {
        return ($this->permissions);
    }
}
