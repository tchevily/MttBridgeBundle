<?php

namespace CanalTP\MttBridgeBundle\Security;

use CanalTP\SamEcoreApplicationManagerBundle\Security\BusinessPermissionManagerInterface;

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

    public function getId()
    {

    }

    public function getName()
    {

    }

    public function getPermissionManagementMode()
    {
    }

    public function getBusinessObjectTypes() {

    }

    public function getBusinessModules()
    {
        return $this->businessModule;
    }
}
