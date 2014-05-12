<?php

namespace CanalTP\MttBridgeBundle\Security;

use CanalTP\SamEcoreApplicationManagerBundle\Security\AbstractBusinessModule;

class BusinessModule extends AbstractBusinessModule
{
    public function getId()
    {

    }

    public function getName()
    {
        return 'time_table_business_module';
    }
}
