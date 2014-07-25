<?php

namespace CanalTP\MttBridgeBundle\Component;

use CanalTP\MttBundle\Services\UserManager;
use CanalTP\MttBridgeBundle\Menu\BusinessMenuItem;
use CanalTP\SamEcoreApplicationManagerBundle\Component\AbstractBusinessComponent;
use CanalTP\SamEcoreApplicationManagerBundle\Perimeter\BusinessPerimeterManagerInterface;
use CanalTP\SamEcoreApplicationManagerBundle\Permission\BusinessPermissionManagerInterface;

/**
 * Description of BusinessComponent
 *
 * @author akambi
 * @author David Quintanel <david.quintanel@canaltp.fr>
 */
class BusinessComponent extends AbstractBusinessComponent
{
    private $businessPermissionManager;
    private $businessPerimeterManager;
    private $userManager;

    public function __construct(
        BusinessPermissionManagerInterface $businessPermissionManager,
        BusinessPerimeterManagerInterface $businessPerimeterManager,
        UserManager $userManager
    )
    {
        $this->businessPermissionManager = $businessPermissionManager;
        $this->businessPerimeterManager = $businessPerimeterManager;
        $this->userManager = $userManager;
    }

    public function getId() {
        return 'mtt_business_component';
    }

    public function getName()
    {
        return 'Business component MTT';
    }

    public function hasPerimeters()
    {
        $perimeters = $this->getPerimetersManager()->getPerimeters();

        return !empty($perimeters);
    }

    public function getMenuItems()
    {
        $userManager = $this->userManager;//->get('canal_tp_mtt.user');

        $networks = new BusinessMenuItem();
        $networks->setAction('#');
        $networks->setName('Réseaux');
        $networks->setRoute('canal_tp_mtt_homepage');


        $userNetworks = $userManager->getNetworks();
        foreach ($userNetworks as $userNetwork) {
            $network = new BusinessMenuItem();
            $network->setAction('#');
            $network->setName($userNetwork['external_id']);
            $network->setRoute('canal_tp_mtt_homepage');
            $networks->addChild($network);
        }

        return array($networks);
    }

    public function getPerimetersManager()
    {
        return $this->businessPerimeterManager;
    }

    public function getPermissionsManager() {
        return $this->businessPermissionManager;
    }
}
