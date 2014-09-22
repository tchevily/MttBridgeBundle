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

        if (count($userNetworks >= 1)) {
            $networks = new BusinessMenuItem();
            $networks->setName($translator->trans('menu.networks'));
            $networks->setRoute('canal_tp_mtt_network_list');
            $currentExternalNetworkId = ($currentExternalNetworkId == null) ? $userNetworks[0]['external_id'] : $currentExternalNetworkId;
            foreach ($userNetworks as $userNetwork) {
                $explodedId = explode(':', $userNetwork['external_id']);
                $network = new BusinessMenuItem();
                $network->setName($explodedId[1]);
                $network->setRoute('canal_tp_mtt_homepage');
                $network->setParameters(array('externalNetworkId' => $userNetwork['external_id']));
                if ($currentExternalNetworkId == $userNetwork['external_id']) {
                    $network->setActive();
                }
                $networks->addChild($network);
            }
            if ($this->container->get('security.context')->isGranted('BUSINESS_EDIT_LAYOUT')) {
                $divider = new \CanalTP\MttBridgeBundle\Menu\Divider();
                $networks->addChild($divider);

                $network = new BusinessMenuItem();
                $network->setName($translator->trans('menu.networks_manage'));
                $network->setRoute('canal_tp_mtt_network_list');
                $networks->addChild($network);
            }

            $menu[] = $networks;
        }

        $currentNetwork = is_null($currentExternalNetworkId) ? $userNetworks[0]['external_id'] : $currentExternalNetworkId;

        // season menu
        if ($this->container->get('security.context')->isGranted('BUSINESS_MANAGE_SEASON')) {
            $seasonManager = $this->container->get('canal_tp_mtt.season_manager');
            $networkSeasons = $seasonManager->findAllByNetworkId($currentNetwork);
            $seasons = new BusinessMenuItem();

            if (count($networkSeasons) >= 1) {
                $seasons->setName($translator->trans('menu.seasons'));
                $seasons->setRoute(null);
                foreach ($networkSeasons as $networkSeason) {
                    $season = new BusinessMenuItem();
                    $season->setName($networkSeason->getTitle());
                    $season->setRoute('canal_tp_mtt_stop_point_list_defaults');
                    $season->setParameters(array(
                        'externalNetworkId' => $currentNetwork,
                        'seasonId' => $networkSeason->getId()
                    ));
                    if ($currentSeasonId == $networkSeason->getId()) {
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


        return $menu;
    }
}
