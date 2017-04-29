<?php

namespace ConferenceSchedulerDevBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Faker\Factory;

class LoadUserData implements FixtureInterface, OrderedFixtureInterface, ContainerAwareInterface {

    const TOTAL_USERS = 100;
    const USER_PASSWORD = 123;

    /**
     * @var ContainerInterface
     */
    private $container;

    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }

    //.. $container declaration & setter

    public function load(ObjectManager $manager) {
        // Get our userManager, you must implement `ContainerAwareInterface`
        $userManager = $this->container->get('fos_user.user_manager');

        $faker = Factory::create();

        for ($x = 0; $x < static::TOTAL_USERS; $x++) {
            $username = $faker->userName;
            $role = 'ROLE_USER';


            if ($x === 0) {
                $username = 'vhr';
            }

            if ($x > 5) {
                $role = 'ROLE_USER';
            }

            // Create our user and set details
            $user = $userManager->createUser();
            $user->setName($faker->name);
            $user->setUsername($username);
            $user->setEmail($faker->safeEmail);
            $user->setPlainPassword(static::USER_PASSWORD);
            $user->setEnabled(true);
            $user->setRoles([$role]);

            // Update the user
            $userManager->updateUser($user, true);
        }
    }

    public function getOrder() {
        return 3;
    }

}
