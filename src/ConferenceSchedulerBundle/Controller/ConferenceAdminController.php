<?php

namespace ConferenceSchedulerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use ConferenceSchedulerBundle\Entity\Conference;
use ConferenceSchedulerBundle\Entity\ConferenceAdmin;
use ConferenceSchedulerBundle\Entity\User;
use ConferenceSchedulerBundle\Event\ConferenceEvent;

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
        return [
            'conference' => $conference,
        ];
    }

    /**
     * Lists all users that not administrators
     *
     * @Route("/invite", name="conference_admin_invite")
     * @Method("GET")
     * @Template()
     * @ParamConverter("conference", class="ConferenceSchedulerBundle:Conference", options={"id"="conference_id"})
     */
    public function inviteAction(Request $request, Conference $conference) {
        $query = $this->getDoctrine()
                ->getManager()
                ->getRepository('ConferenceSchedulerBundle:User')
                ->findAdminsWithoutConferenceQuery($conference);

        $pagination = $this->get('knp_paginator')
                ->paginate($query, $request->query->getInt('page', 1))
        ;


        return [
            'conference' => $conference,
            'pagination' => $pagination,
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
        $em = $this->getDoctrine()->getManager();
        $role = $em->getRepository('ConferenceSchedulerBundle:Role')
                ->findOneBy([
            'role' => ConferenceAdmin::ROLE_CONFERENCE_ADMIN
                ])
        ;

        $admin = new ConferenceAdmin;
        $admin->setUser($user);
        $admin->setConference($conference);
        $admin->setRole($role);

        $conference->addAdmin($admin);

        $em->flush();

        // dispatch event
        $event = new ConferenceEvent($conference, $user);
        $this->get('event_dispatcher')
                ->dispatch(ConferenceEvent::EVENT_ADMIN_ADD, $event);
        
        // flashbag
        $this->addFlash('notice', 'User is added');

        return $this->redirectToRoute('conference_admin_invite', [
                    'conference_id' => $conference->getId(),
        ]);
    }

    /**
     * Creates a new conference entity.
     *
     * @Route("/{id}/remove", name="conference_admin_remove")
     * @Method({"GET"})
     * @ParamConverter("conference", class="ConferenceSchedulerBundle:Conference", options={"id"="conference_id"})
     */
    public function removeAction(Conference $conference, User $user) {
        $em = $this->getDoctrine()->getManager();

        $criteria = [
            'conference' => $conference,
            'user' => $user,
        ];

        // before remove relation check if someone is still be administrator of conference
        $admin = $em->getRepository('ConferenceSchedulerBundle:ConferenceAdmin')
                ->findOneBy($criteria)
        ;

        if ($admin === null) {
            goto redirectToList;
        }

        $em->remove($admin);
        $em->flush();

        // dispatch event
        $event = new ConferenceEvent($conference, $user);
        $this->get('event_dispatcher')
                ->dispatch(ConferenceEvent::EVENT_ADMIN_ADD, $event);
        
        // flashbag
        $this->addFlash('notice', 'User has been removed from administrators');

        redirectToList: {
            return $this->redirectToRoute('conference_admin_index', [
                        'conference_id' => $conference->getId(),
            ]);
        }
    }

}
