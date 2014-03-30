<?php

namespace CanalTP\MttBusinessAppBundle\Security;

use Doctrine\Common\Persistence\ObjectManager;
use CanalTP\Sam\Ecore\ApplicationManagerBundle\Security\BusinessPerimeterInterface;

class BusinessPerimeterManager implements BusinessPerimeterInterface
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
        return $this->repository->findAll();
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
