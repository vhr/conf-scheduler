<?php

namespace ConferenceSchedulerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use ConferenceSchedulerBundle\Entity\Conference;
use ConferenceSchedulerBundle\Entity\User;

/**
 * Conference users controller.
 *
 * @Route("conference/{conference_id}/users")
 */
class ConferenceUserController extends Controller {

    /**
     * Lists all conference entities.
     *
     * @Route("/", name="conference_user_index")
     * @Method("GET")
     * @Template()
     * @ParamConverter("conference", class="ConferenceSchedulerBundle:Conference", options={"id"="conference_id"})
     */
    public function indexAction(Conference $conference) {
        $em = $this->getDoctrine()->getManager();

        $users = $conference->getUsers();

        return [
            'conference' => $conference,
            'users' => $users,
        ];
    }

}
