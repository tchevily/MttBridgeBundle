<?php

namespace CanalTP\MttBridgeBundle\Security;

use Doctrine\Common\Persistence\ObjectManager;
use CanalTP\SamEcoreApplicationManagerBundle\Security\BusinessPerimeterManagerInterface;
use CanalTP\SamEcoreApplicationManagerBundle\Security\BusinessPerimeterInterface;
use CanalTP\SamEcoreApplicationManagerBundle\Security\BusinessPerimeter;
use Symfony\Component\Security\Core\UserInterface;

class BusinessPerimeterManager implements BusinessPerimeterManagerInterface
{
    private $repository;
    private $objectManager;

    public function __construct(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
        $this->repository = $objectManager->getRepository('CanalTPMttBundle:Network');
    }

    public function getId()
    {

    }

    public function getName()
    {

    }

    /**
     * Add a user to a perimeter
     *
     * @param UserInterface              $user
     * @param BusinessPerimeterInterface $perimeter
     */
    public function addUserToPerimeter(UserInterface $user, BusinessPerimeterInterface $perimeter)
    {

    }

    /**
     * Get the perimeters
     *
     * @return BusinessPerimeterInterface[] The perimeters
     */
    public function getPerimeters()
    {
        $networks = $this->repository->findAll();

        $perimeters = array();
        foreach ($networks as $network) {
            $perimeter = new BusinessPerimeter($network->getExternalId());
            $perimeter->setId($network->getId());
            $perimeters[] = $perimeter;
        }

        return $perimeters;
    }

    /**
     * Delete a user from a perimeter
     *
     * @param UserInterface              $user
     * @param BusinessPerimeterInterface $perimeter
     */
    public function deleteUserFromPerimeter(UserInterface $user, BusinessPerimeterInterface $perimeter)
    {

    }

    /**
     * Get a user's perimeters
     *
     * @param UserInterface $user
     *
     * @return BusinessPerimeterInterface[] The perimeters
     */
    public function getUserPerimeters(UserInterface $user)
    {

    }
}
