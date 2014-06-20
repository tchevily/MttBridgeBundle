<?php

namespace CanalTP\MttBridgeBundle\Monitoring;

use CanalTP\SamMonitoringComponent\Service\AbstractServiceMonitor;
use CanalTP\SamMonitoringComponent\StateMonitorInterface as State;

class Service extends AbstractServiceMonitor
{
    protected $name;
    protected $state;

    public function __construct()
    {
        parent::__construct();

        $this->name = 'SERVICE_NAME';
        $this->state = State::UP;
    }
}
