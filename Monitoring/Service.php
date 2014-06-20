<?php

namespace CanalTP\MttBridgeBundle\Monitoring;

use CanalTP\SamMonitoringComponent\MonitorableServiceInterface;
use CanalTP\SamMonitoringComponent\MonitoringStateInterface as State;

class Service implements MonitorableServiceInterface
{
    protected $name;
    protected $state;

    public function __construct()
    {
        $this->name = 'SERVICE_NAME';
        $this->state = State::UP;
    }

    public function getName() {
        return ($this->name);
    }

    public function getState() {
        return ($this->state);
    }
}
