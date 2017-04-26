<?php

namespace ConferenceSchedulerBundle\ParamConverter;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Doctrine\ORM\EntityManagerInterface;
use ConferenceSchedulerBundle\Entity\User;
use ConferenceSchedulerBundle\Entity\Conference;
use ConferenceSchedulerBundle\Entity\ConferenceLecturer;

/**
 * Conference manager
 * 
 * @author Valentin Hristov <v.hristov@mail.ru>
 */
class ConferenceManager implements ParamConverterInterface {

    /**
     * @var EntityManagerInterface
     */
    private $registry;

    /**
     * Construct
     * 
     * @param EntityManagerInterface $registry Manager registry
     */
    public function __construct(EntityManagerInterface $registry) {
        $this->registry = $registry;
    }

    /**
     * Add lecture to conference
     */
    public function addLecture(User $user) {
        // Get actual entity manager for class
        $em = $this->registry->getRepository('ConferenceSchedulerBundle:ConferenceLecturer');

        // Check, if class name is what we need
        if ($em->getClassName() !== 'ConferenceSchedulerBundle\Entity\Conference') {
            return false;
        }

        return true;
    }

}
