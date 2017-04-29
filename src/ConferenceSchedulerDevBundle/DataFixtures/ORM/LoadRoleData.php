<?php

namespace ConferenceSchedulerDevBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use ConferenceSchedulerBundle\Entity\Role;

class LoadUserData implements FixtureInterface, OrderedFixtureInterface, ContainerAwareInterface {

    const TOTAL_USERS = 100;
    const USER_PASSWORD = 123;

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * Load constructor
     * 
     * @param ContainerInterface $container
     */
    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }

    /**
     * Load
     * 
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager) {
        $roles = [
            'ROLE_CONFERENCE_OWNER' => 'Conference owner',
            'ROLE_CONFERENCE_ADMIN' => 'Conference administrator',
        ];

        foreach ($roles as $role => $name) {
            $entity = new Role;
            $entity->setName($name);
            $entity->setRole($role);

            $manager->persist($entity);
        }
        $manager->flush();
    }

    public function getOrder() {
        return 1;
    }

}
