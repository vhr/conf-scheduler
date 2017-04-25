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
 * Conference administrators controller.
 *
 * @Route("conference/{conference_id}/admins")
 */
class ConferenceAdminController extends Controller {

    /**
     * Lists all conference entities.
     *
     * @Route("/", name="conference_admin_index")
     * @Method("GET")
     * @Template()
     * @ParamConverter("conference", class="ConferenceSchedulerBundle:Conference", options={"id"="conference_id"})
     */
    public function indexAction(Conference $conference) {
        $em = $this->getDoctrine()->getManager();

        $admins = $em->getRepository('ConferenceSchedulerBundle:User')
                ->findAdminsWithoutConference($conference);

        return [
            'conference' => $conference,
            'admins' => $admins,
        ];
    }

    /**
     * Creates a new conference entity.
     *
     * @Route("/{id}/add", name="conference_admin_add")
     * @Method({"GET"})
     * @ParamConverter("conference", class="ConferenceSchedulerBundle:Conference", options={"id"="conference_id"})
     */
    public function addAction(Conference $conference, User $user) {
        $conference->addAdmin($user);

        $this->getDoctrine()->getManager()->flush();
        
        // @todo send notification to user

        return $this->redirectToRoute('conference_admin_index', [
                    'conference_id' => $conference->getId(),
        ]);
    }

    /**
     * Creates a new conference entity.
     *
     * @Route("/{id}/remove", name="conference_admin_remove")
     * @Method({"GET"})
     */
    public function removeAction(Conference $conference, User $user) {
        // @todo before remove relation check if someone is still be administrator of conference
        $conference->removeAdmin($user);

        $this->getDoctrine()->getManager()->flush();

        return $this->redirectToRoute('conference_admin_index', [
                    'conference_id' => $conference->getId(),
        ]);
    }

}
