<?php

namespace CanalTP\MttBusinessAppBundle\Security;

use CanalTP\Sam\Ecore\ApplicationManagerBundle\Security\BusinessComponentInterface;
use CanalTP\MttBusinessAppBundle\Security\BusinessMenuItem;
use Symfony\Component\DependencyInjection\Container;

/**
 * Description of BusinessComponent
 *
 * @author akambi
 */
class BusinessComponent implements BusinessComponentInterface
{
    private $businessPermissionManager;
    protected $container;

    public function __construct($businessPermissionManager, Container $container)
    {
        $this->businessPermissionManager = $businessPermissionManager;
        $this->container = $container;
    }

    public function getId() {
        return 'mtt_business_component';
    }

    public function getName()
    {
        return 'Business component MTT';
    }

    public function hasPerimeters() {
    }

    public function getMenuItems()
    {
        $userManager = $this->container->get('canal_tp_mtt.user');

        $networks = new BusinessMenuItem();
        $networks->setAction('#');
        $networks->setName('Network');
        $networks->setRoute('canal_tp_mtt_homepage');


        $userNetworks = $userManager->getNetworks();
        foreach ($userNetworks as $userNetwork) {
            $network = new BusinessMenuItem();
            $network->setAction('#');
            $network->setName($userNetwork['external_id']);
            $network->setRoute('canal_tp_mtt_homepage');
            $networks->addChild($network);
        }

        $seasons = new BusinessMenuItem();
        $seasons->setAction('#');
        $seasons->setName('Gestion des saisons');
        $seasons->setRoute('canal_tp_mtt_season_list');
        $seasons->setParameters(array(
            'coverage_id' => $userNetworks[0]['external_coverage_id'],
            'network_id' => $userNetworks[0]['external_id']
        ));


        return array($networks, $seasons);
    }

    public function getPerimetersManager() {

    }

    public function getPermissionsManager() {
        return $this->businessPermissionManager;
    }
}
