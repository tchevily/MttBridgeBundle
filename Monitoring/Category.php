<?php

namespace CanalTP\MttBridgeBundle\Monitoring;

use CanalTP\SamMonitoringComponent\MonitorableCategoryInterface;

class Category implements MonitorableCategoryInterface
{
    protected $name;
    protected $services;

    public function __construct()
    {
        $this->name = 'CATEGORY_NAME';
        $this->services = array();
    }

    private function initServices() {
        $this->services[] = new Service();
        $this->services[] = new Service();
    }

    public function getName() {
        return ($this->name);
    }

    public function getServices() {
        return ($this->services);
    }
}
