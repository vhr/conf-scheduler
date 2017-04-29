<?php

namespace ConferenceSchedulerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use ConferenceSchedulerBundle\Entity\Conference;
use ConferenceSchedulerBundle\Entity\ConferenceUser;
use ConferenceSchedulerBundle\Entity\User;
use ConferenceSchedulerBundle\Event\ConferenceEvent;

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
        $totalUsers = $this->getDoctrine()
                ->getManager()
                ->getRepository('ConferenceSchedulerBundle:ConferenceUser')
                ->countByConference($conference);

        return [
            'conference' => $conference,
            'totalUsers' => $totalUsers,
        ];
    }

    /**
     * Lists all users that not add to conference
     *
     * @Route("/invite", name="conference_user_invite")
     * @Method("GET")
     * @Template()
     * @ParamConverter("conference", class="ConferenceSchedulerBundle:Conference", options={"id"="conference_id"})
     */
    public function inviteAction(Request $request, Conference $conference) {
        $query = $this->getDoctrine()
                ->getManager()
                ->getRepository('ConferenceSchedulerBundle:User')
                ->findNotUserOrLecturerInConferenceQuery($conference);

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
     * @Route("/{id}/add", name="conference_user_add")
     * @Method("GET")
     * @Template()
     * @ParamConverter("conference", class="ConferenceSchedulerBundle:Conference", options={"id"="conference_id"})
     */
    public function addAction(Conference $conference, User $user) {
        $em = $this->getDoctrine()->getManager();

        $limit = $conference->getHall()->getUserLimit();
        $totalUsers = $em->getRepository('ConferenceSchedulerBundle:ConferenceUser')
                ->countByConference($conference);

        // check for user limit of hall
        if ($totalUsers >= $limit) {
            $this->addFlash('notice', 'You have reached the limit of the hall');

            goto redirectToList;
        }

        $conferenceUser = new ConferenceUser;
        $conferenceUser->setConference($conference);
        $conferenceUser->setUser($user);

        $conference->addUser($conferenceUser);

        $em->flush();

        // dispatch event
        $event = new ConferenceEvent($conference, $user);
        $this->get('event_dispatcher')
                ->dispatch(ConferenceEvent::EVENT_USER_ADD, $event);

        // flashbag
        $this->addFlash('notice', 'User has been add to the conference');

        redirectToList: {
            return $this->redirectToRoute('conference_user_invite', [
                        'conference_id' => $conference->getId(),
            ]);
        }
    }

    /**
     * Remove user from conference
     *
     * @Route("/{id}/remove", name="conference_user_remove")
     * @Method("GET")
     * @Template()
     * @ParamConverter("conference", class="ConferenceSchedulerBundle:Conference", options={"id"="conference_id"})
     */
    public function removeAction(Conference $conference, User $user) {
        $em = $this->getDoctrine()->getManager();

        // find relation lecture with conference
        $conferenceUser = $em->getRepository('ConferenceSchedulerBundle:ConferenceUser')
                ->findOneBy([
            'conference' => $conference,
            'user' => $user,
        ]);

        if ($conferenceUser === null) {
            goto redirectToList;
        }

        $em->remove($conferenceUser);
        $em->flush();

        // dispatch event
        $event = new ConferenceEvent($conference, $user);
        $this->get('event_dispatcher')
                ->dispatch(ConferenceEvent::EVENT_USER_DELETE, $event);

        // flashbag
        $this->addFlash('notice', 'User has been removed from conference');

        redirectToList: {
            return $this->redirectToRoute('conference_user_index', [
                        'conference_id' => $conference->getId(),
            ]);
        }
    }

}
