<?php

namespace CanalTP\MttBusinessAppBundle\Security;

use CanalTP\Sam\Ecore\ApplicationManagerBundle\Security\AbstractBusinessModule;

class BusinessModule extends AbstractBusinessModule
{
    public function __construct($permissions)
    {
        $this->permissions = $permissions;
    }

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
