<?php

namespace CanalTP\MttBridgeBundle\Permission;

use CanalTP\SamEcoreApplicationManagerBundle\Permission\AbstractBusinessPermissionManager;

/**
 * Description of BusinessComponent
 *
 * @author akambi
 */
class BusinessPermissionManager extends AbstractBusinessPermissionManager
{
    private $businessModule;

    public function __construct($businessModule)
    {
        $this->businessModule = $businessModule;
    }

    public function getBusinessModules()
    {
        return $this->businessModule;
    }
}
