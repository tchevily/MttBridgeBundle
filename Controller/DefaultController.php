<?php

namespace CanalTP\MttBusinessAppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('CanalTPMttBusinessAppBundle:Default:index.html.twig', array('name' => $name));
    }
}
