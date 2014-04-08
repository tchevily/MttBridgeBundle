<?php

namespace CanalTP\MttBridgeBundle\Security;

use CanalTP\Sam\Ecore\ApplicationManagerBundle\Security\BusinessMenuItemInterface;

/**
 * Description of BusinessMenuItem
 *
 * @author Kévin Ziemianski <kevin.ziemianski@canaltp.fr>
 */
class BusinessMenuItem implements BusinessMenuItemInterface
{
    protected $action;
    protected $children = array();
    protected $id;
    protected $name;
    protected $route;
    protected $parameters;

    public function setAction($action) {
        $this->action = $action;
    }

    public function getAction() {
        return $this->action;
    }

    public function addChild($child)
    {
        $this->children[] = $child;
    }

    public function getChildren() {
        return $this->children;
    }

    public function getId() {

    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getName() {
        return $this->name;
    }

    public function setRoute($route) {
        $this->route = $route;
    }

    public function getRoute() {
        return $this->route;
    }

    public function setParameters($parameters) {
        $this->parameters = $parameters;
    }

    public function getParameters() {
        return $this->parameters;
    }
}
