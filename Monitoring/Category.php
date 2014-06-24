<?php

namespace CanalTP\MttBridgeBundle\Monitoring;

use CanalTP\SamMonitoringComponent\Category\CategoryMonitor;

class Category extends CategoryMonitor
{
    public function __construct()
    {
        parent::__construct();

        $this->name = 'CATEGORY_NAME';
        $this->initServices();
    }

    private function initServices() {
        $this->addService(new Service());
        $this->addService(new Service());
    }
}
