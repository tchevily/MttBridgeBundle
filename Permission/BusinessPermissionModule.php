<?php

namespace CanalTP\MttBridgeBundle\Permission;

use CanalTP\SamEcoreApplicationManagerBundle\Permission\AbstractBusinessPermissionModule;

class BusinessPermissionModule extends AbstractBusinessPermissionModule
{
    public function getId()
    {

    }

    public function getName()
    {
        return 'time_table_business_module';
    }
}
