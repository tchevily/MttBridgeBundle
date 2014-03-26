<?php

namespace CanalTP\MttBusinessAppBundle\Security;

use CanalTP\Sam\Ecore\ApplicationManagerBundle\Security\BusinessPermissionManagerInterface;

/**
 * Description of BusinessComponent
 *
 * @author akambi
 */
class BusinessPermissionManager implements BusinessPermissionManagerInterface
{
    private $businessModule;

    public function __construct($businessModule)
    {
        $this->businessModule = $businessModule;
    }

    public function getPermissionManagementMode()
    {
    }

    public function getBusinessObjectTypes()
    {
    }

    public function getBusinessModules()
    {
        return $this->businessModule;
    }
}
