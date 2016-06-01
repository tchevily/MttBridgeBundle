<?php

namespace CanalTP\MttBridgeBundle\Menu\MenuManager;

use CanalTP\MttBridgeBundle\Menu\MenuManager;
use Prophecy\Argument;

class MenuManagerTest extends \PHPUnit_Framework_TestCase
{
    public function testGetMenu()
    {
        $userManagerMock = $this->prophesize('\CanalTP\MttBundle\Services\UserManager');

        $containerMock = $this->prophesize('\Symfony\Component\DependencyInjection\Container');
        $requestStackMock = $this->prophesize('Symfony\Component\HttpFoundation\RequestStack');

        $attributesMock = $this->prophesize('Symfony\Component\HttpFoundation\ParameterBag');
        $attributesMock->get('seasonId')->willReturn('1');
        $attributesMock->get('externalNetworkId')->willReturn('network:1');

        $requestMock = $this->prophesize('\Symfony\Component\HttpFoundation\Request');
        $requestMock->attributes = $attributesMock->reveal();
        $requestStackMock->getCurrentRequest()
            ->willReturn($requestMock->reveal());

        $translatorMock = $this->prophesize('Symfony\Component\Translation\Translator');
        $translatorMock->trans(Argument::type('string'))->will(function ($arguments) {
            return $arguments[0];
        });

        $containerMock->get(Argument::type('string'))->willReturn($requestStackMock->reveal());

        $securityContextMock = $this->prophesize('\Symfony\Component\Security\Core\SecurityContext');

        $securityContextMock->isGranted(Argument::type('string'))->willReturn(false);
        $securityContextMock->isGranted(Argument::type('array'))->willReturn(false);

        $attributesGroups = [
            ['BUSINESS_LIST_AREA', 'BUSINESS_MANAGE_AREA'],
            ['BUSINESS_MANAGE_LAYOUT_CONFIG'],
            'BUSINESS_MANAGE_LAYOUT_MODEL',
            'BUSINESS_ASSIGN_MODEL'
        ];
        foreach ($attributesGroups as $attributes) {
            $securityContextMock->isGranted($attributes)->willReturn(true);
        }

        $containerMock->get('security.context')->willReturn($securityContextMock->reveal());
        $containerMock->get('translator')->willReturn($translatorMock->reveal());

        $menuManager = new MenuManager($userManagerMock->reveal(), $containerMock->reveal());
        $menu = $menuManager->getMenu();

        $this->assertInternalType('array', $menu, 'It should return a menu as an array.');
        $menuItemsCount = 5;
        $this->assertCount(
            $menuItemsCount,
            $menu,
            sprintf(
                'The menu should contain "%d".',
                $menuItemsCount
            )
        );

        $menuItemClass = 'CanalTP\MttBridgeBundle\Menu\BusinessMenuItem';
        foreach (range(0, 4) as $menuIndex) {
            $this->assertInstanceOf(
                $menuItemClass,
                $menu[$menuIndex],
                sprintf(
                    'The #%d menu item should be an instance of "%s".',
                    $menuIndex,
                    $menuItemClass
                )
            );
        }

        $menuLabelsAssertions = [
            'menu.calendar_list' =>
                'The default menu item should be a label inviting to list calendars.',
            'menu.edit_timetables' =>
                'The default menu item should be a label inviting to edit timetables.',
            'menu.area_manage' =>
                'This menu item should be a label inviting to manage area.',
            'menu.layouts_manage' =>
                'This menu item should be a label inviting to manage layout.',
            'menu.administration' =>
                'This menu item should be administration.',
        ];

        $menuIndex = 0;
        foreach ($menuLabelsAssertions as $menuLabel => $message) {
            $this->assertEquals(
                $menuLabel,
                $menu[$menuIndex]->getName(),
                $message
            );
            $menuIndex++;
        }
    }
}
