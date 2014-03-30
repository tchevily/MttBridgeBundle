<?php

namespace CanalTP\MttBridgeBundle\Security;

use CanalTP\Sam\Ecore\ApplicationManagerBundle\Security\BusinessPermissionInterface;

/**
 * Description of BusinessComponent
 *
 * @author akambi
 */
class BusinessPermissionManager implements BusinessPermissionInterface
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
