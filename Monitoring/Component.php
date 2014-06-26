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
    }

    private function checkServices($category)
    {
        foreach ($category->getServices() as $service) {
            if ($service->getState() == State::DOWN) {
                $this->state = State::DOWN;
                break;
            }
        }
    }

    private function checkCategories()
    {
        foreach ($this->categories as $category) {
            $this->checkServices($category);
            if ($this->state == State::DOWN) {
                break;
            }
        }
    }

    public function check()
    {
        parent::check();

        $this->checkCategories();
        $this->state = ($this->state == State::UNKNOWN) ? State::UP: $this->state;
    }
}
