<?php

namespace CanalTP\MttBridgeBundle\Menu;

use Symfony\Component\HttpFoundation\RequestStack;
use CanalTP\MttBundle\Services\UserManager;
use CanalTP\MttBridgeBundle\Menu\BusinessMenuItem;
use Symfony\Component\DependencyInjection\Container;

/**
 * Description of MenuManager
 *
 * @author Kévin Ziemianski <kevin.ziemianski@canaltp.fr>
 */
class MenuManager
{
    private $userManager;
    private $container;
    private $requestStack;

    public function __construct(
        UserManager $userManager,
        Container $container
    ) {
        $this->userManager = $userManager;
        $this->container = $container;
        $this->requestStack = $container->get('request_stack');
    }

    public function getMenu()
    {
        $userManager = $this->userManager;
        $userNetworks = $userManager->getNetworks();
        $currentExternalNetworkId = $this->requestStack->getCurrentRequest()->attributes->get('externalNetworkId');
        $currentSeasonId = $this->requestStack->getCurrentRequest()->attributes->get('seasonId');
        $translator = $this->container->get('translator');
        $menu = array();

        if (count($userNetworks) >= 1) {
            $perimeters = new BusinessMenuItem();
            $perimeters->setName($translator->trans('menu.networks'));
            $perimeters->setRoute('canal_tp_mtt_network_list');
            $currentExternalNetworkId = ($currentExternalNetworkId == null) ? $userNetworks->first()->getExternalNetworkId() : $currentExternalNetworkId;
            foreach ($userNetworks as $userNetwork) {
                $explodedId = explode(':', $userNetwork->getExternalNetworkId());
                $perimeter = new BusinessMenuItem();
                $perimeter->setName($explodedId[1]);
                $perimeter->setRoute('canal_tp_mtt_homepage');
                $perimeter->setParameters(array('externalNetworkId' => $userNetwork->getExternalNetworkId()));
                if ($currentExternalNetworkId == $userNetwork->getExternalNetworkId()) {
                    $perimeter->setActive();
                }
                $perimeters->addChild($perimeter);
            }

            $menu[] = $perimeters;
        }

        $currentNetwork = is_null($currentExternalNetworkId) ? $userNetworks->first()->getExternalNetworkId() : $currentExternalNetworkId;

        $securityContext = $this->container->get('security.context');
        // season menu
        if ($securityContext->isGranted('BUSINESS_MANAGE_SEASON')) {
            $seasonManager = $this->container->get('canal_tp_mtt.season_manager');
            $perimeterManager = $this->container->get('nmm.perimeter_manager');
            $perimeter = $perimeterManager->findOneByExternalNetworkId(
                $securityContext->getToken()->getUser(),
                $currentNetwork
            );
            $perimeterSeasons = $seasonManager->findByPerimeter($perimeter);
            $seasons = new BusinessMenuItem();

            if (count($perimeterSeasons) >= 1) {
                $seasons->setName($translator->trans('menu.seasons'));
                $seasons->setRoute(null);
                foreach ($perimeterSeasons as $perimeterSeason) {
                    $season = new BusinessMenuItem();
                    $season->setName($perimeterSeason->getTitle());
                    $season->setRoute('canal_tp_mtt_stop_point_list_defaults');
                    $season->setParameters(array(
                        'externalNetworkId' => $currentNetwork,
                        'seasonId' => $perimeterSeason->getId()
                    ));
                    if ($currentSeasonId == $perimeterSeason->getId()) {
                        $season->setActive();
                    }
                    $seasons->addChild($season);
                }
                $divider = new \CanalTP\MttBridgeBundle\Menu\Divider();
                $seasons->addChild($divider);

                $season = new BusinessMenuItem();
                $season->setName($translator->trans('menu.seasons_manage'));
                $season->setRoute('canal_tp_mtt_season_list');
                $season->setParameters(array(
                    'externalNetworkId' => $currentNetwork
                ));
                $seasons->addChild($season);
            } else {
                $seasons->setName($translator->trans('menu.seasons_manage'));
                $seasons->setRoute('canal_tp_mtt_season_list');
                $seasons->setParameters(array(
                    'externalNetworkId' => $currentNetwork
                ));
            }

            $menu[] = $seasons;
        }

        $edit = new BusinessMenuItem();
        $edit->setName($translator->trans('menu.edit_timetables'));
        $edit->setRoute('canal_tp_mtt_stop_point_list_defaults');
        $edit->setParameters(array(
            'externalNetworkId' => $currentNetwork
        ));

        $menu[] = $edit;

        if ($this->container->get('security.context')->isGranted(array('BUSINESS_LIST_AREA', 'BUSINESS_MANAGE_AREA'))) {
            $area = new BusinessMenuItem();
            $area->setName($translator->trans('menu.area_manage'));
            $area->setRoute('canal_tp_mtt_area_list');
            $area->setParameters(array(
                'externalNetworkId' => $currentNetwork
            ));

            $menu[] = $area;
        }

        if ($this->container->get('security.context')->isGranted(array('BUSINESS_LIST_LAYOUT_CONFIG', 'BUSINESS_MANAGE_LAYOUT_CONFIG'))) {
            $layout = new BusinessMenuItem();
            $layout->setName($translator->trans('menu.layouts_manage'));
            $layout->setRoute('canal_tp_mtt_layout_config_list');
            $layout->setParameters(array(
                'externalNetworkId' => $currentNetwork
            ));

            $menu[] = $layout;
        }

        if ($this->container->get('security.context')->isGranted('BUSINESS_LIST_CUSTOMER')) {
            $customer = new BusinessMenuItem();
            $customer->setName($translator->trans('menu.customer_manage'));
            $customer->setRoute('canal_tp_mtt_customer_list');
            $customer->setParameters(array(
                'externalNetworkId' => $currentNetwork
            ));

            $menu[] = $customer;
        }


        return $menu;
    }
}
