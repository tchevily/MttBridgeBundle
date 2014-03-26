<?php

namespace CanalTP\MttBusinessAppBundle\Security;

use CanalTP\Sam\Ecore\ApplicationManagerBundle\Security\BusinessComponentInterface;

/**
 * Description of BusinessComponent
 *
 * @author akambi
 */
class BusinessComponent implements BusinessComponentInterface
{
    private $businessPermissionManager;

    public function __construct($businessPermissionManager)
    {
        $this->businessPermissionManager = $businessPermissionManager;
    }

    public function getId()
    {
        return 'mtt_business_component';
    }

    public function getName()
    {
        return 'Business component MTT';
    }

    public function hasPerimeters()
    {
    }

    public function getMenuItems()
    {
    }

    public function getPerimetersManager()
    {
    }

    public function getPermissionsManager()
    {
        return $this->businessPermissionManager;
    }
}
