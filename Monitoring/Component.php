<?php

namespace CanalTP\MttBridgeBundle\Monitoring;

use CanalTP\SamMonitoringComponent\StateMonitorInterface as State;
use CanalTP\SamMonitoringComponent\Component\AbstractComponentMonitor;

class Component extends AbstractComponentMonitor
{
    public function __construct()
    {
        parent::__construct();

        $this->name = 'TimeTable';
        $this->state = State::UP;
    }
}
