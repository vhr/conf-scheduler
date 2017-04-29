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
use ConferenceSchedulerBundle\Entity\ConferenceLecturer;
use ConferenceSchedulerBundle\Event\ConferenceEvent;

/**
 * Conference lecturers controller.
 *
 * @Route("conference/{conference_id}/lecturers")
 */
class ConferenceLecturerController extends Controller {

    /**
     * Lists all conference entities.
     *
     * @Route("/", name="conference_lecturer_index")
     * @Method("GET")
     * @Template()
     * @ParamConverter("conference", class="ConferenceSchedulerBundle:Conference", options={"id"="conference_id"})
     */
    public function indexAction(Conference $conference) {
        $lecturers = $conference->getLecturers();

        return [
            'conference' => $conference,
            'lecturers' => $lecturers,
        ];
    }

    /**
     * Lists all users that not lecturers
     *
     * @Route("/invite", name="conference_lecturer_invite")
     * @Method("GET")
     * @Template()
     * @ParamConverter("conference", class="ConferenceSchedulerBundle:Conference", options={"id"="conference_id"})
     */
    public function inviteAction(Request $request, Conference $conference) {
        $query = $this->getDoctrine()
                ->getManager()
                ->getRepository('ConferenceSchedulerBundle:User')
                ->findNotLecturerInConferenceQuery($conference);

        $pagination = $this->get('knp_paginator')
                ->paginate($query, $request->query->getInt('page', 1))
        ;


        return [
            'conference' => $conference,
            'pagination' => $pagination,
        ];
    }

    /**
     * Add user to conference
     *
     * @Route("/{id}/add", name="conference_lecturer_add")
     * @Method("GET")
     * @Template()
     * @ParamConverter("conference", class="ConferenceSchedulerBundle:Conference", options={"id"="conference_id"})
     */
    public function addAction(Conference $conference, User $user) {
        $em = $this->getDoctrine()->getManager();

        $lecturer = new ConferenceLecturer;
        $lecturer->setConference($conference);
        $lecturer->setUser($user);

        $conference->addLecturer($lecturer);

        $em->flush();

        // dispatch event
        $event = new ConferenceEvent($conference, $this->getUser());
        $this->get('event_dispatcher')
                ->dispatch(ConferenceEvent::EVENT_LECTURER_ADD, $event);

        // flashbag
        $this->addFlash('notice', 'Invitation has sent');

        return $this->redirectToRoute('conference_lecturer_invite', [
                    'conference_id' => $conference->getId(),
        ]);
    }

    /**
     * Remove user from conference
     *
     * @Route("/{id}/remove", name="conference_lecturer_remove")
     * @Method("GET")
     * @Template()
     * @ParamConverter("conference", class="ConferenceSchedulerBundle:Conference", options={"id"="conference_id"})
     */
    public function removeAction(Conference $conference, User $user) {
        $em = $this->getDoctrine()->getManager();

        // find relation lecture with conference
        $lecturer = $em->getRepository('ConferenceSchedulerBundle:ConferenceLecturer')
                ->findOneBy([
            'conference' => $conference,
            'user' => $user,
        ]);

        $em->remove($lecturer);
        $em->flush();

        // dispatch event
        $event = new ConferenceEvent($conference, $this->getUser());
        $this->get('event_dispatcher')
                ->dispatch(ConferenceEvent::EVENT_LECTURER_DELETE, $event);

        // flashbag
        $this->addFlash('notice', 'User has been removed from lecturers');

        return $this->redirectToRoute('conference_lecturer_index', [
                    'conference_id' => $conference->getId(),
        ]);
    }

}
