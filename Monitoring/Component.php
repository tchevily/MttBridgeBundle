<?php

namespace CanalTP\MttBridgeBundle\Monitoring;

use CanalTP\SamMonitoringComponent\MonitorableComponentInterface;
use CanalTP\SamMonitoringComponent\MonitoringStateInterface as State;

class Component implements MonitorableComponentInterface
{
    protected $name;
    protected $state;
    protected $categories = array();

    public function __construct()
    {
        $this->name = 'TimeTable';
        $this->state = State::UP;
        $this->categories = array();

        $this->initCategories();
    }

    private function initCategories() {
        $this->categories[] = new Category();
        $this->categories[] = new Category();
        $this->categories[] = new Category();
    }

    public function getName() {
        return ($this->name);
    }

    public function getState() {
        return ($this->state);
    }

    public function getCategories() {
        return ($this->categories);
    }
}
