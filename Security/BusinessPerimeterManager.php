<?php

namespace CanalTP\MttBridgeBundle\Security;

use Doctrine\Common\Persistence\ObjectManager;
use CanalTP\MttBundle\Services\NetworkManager;
use CanalTP\SamEcoreApplicationManagerBundle\Security\BusinessPerimeterManagerInterface;
use CanalTP\SamEcoreApplicationManagerBundle\Security\BusinessPerimeterInterface;
use CanalTP\SamEcoreApplicationManagerBundle\Security\BusinessPerimeter;
use FOS\UserBundle\Model\UserInterface;

class BusinessPerimeterManager implements BusinessPerimeterManagerInterface
{
    private $repository;
    private $objectManager;
    private $perimeters;

    public function __construct(NetworkManager $networkManager)
    {
        $this->networkManager = $networkManager;
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
        $this->networkManager->addUserToNetwork($user->getId(), $perimeter->getId());
    }

    /**
     * Get the perimeters
     *
     * @return BusinessPerimeterInterface[] The perimeters
     */
    public function getPerimeters()
    {
        if (null === $this->perimeters) {
            $perimeters = array();
            foreach ($this->networkManager->findAll() as $network) {
                $perimeter = new BusinessPerimeter($network->getExternalId());
                $perimeter->setId($network->getId());
                $this->perimeters[] = $perimeter;
            }
        }

        return $this->perimeters;
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
        $userPerimeters = array();
        foreach ($this->networkManager->findUserNetworks($user) as $network) {
            foreach ($this->getPerimeters() as $perimeter) {
                if ($perimeter->getId() == $network['id'] && $perimeter->getName() == $network['external_id']) {
                    $userPerimeters[] = $perimeter;
                    break 1;
                }
            }
        }

        return $userPerimeters;
    }
}
