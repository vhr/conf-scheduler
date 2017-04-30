<?php

namespace ConferenceSchedulerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use ConferenceSchedulerBundle\Entity\Conference;
use ConferenceSchedulerBundle\Entity\ConferenceUser;
use ConferenceSchedulerBundle\Event\ConferenceEvent;

class PublicConferenceController extends Controller {

    /**
     * @Route("/", name="homepage")
     * @Template()
     */
    public function indexAction(Request $request) {
        $query = $this->getDoctrine()
                ->getManager()
                ->getRepository('ConferenceSchedulerBundle:Conference')
                ->findAllByAccessQuery($this->getUser());

        $pagination = $this->get('knp_paginator')
                ->paginate($query, $request->query->getInt('page', 1))
        ;

        return [
            'pagination' => $pagination,
        ];
    }

    /**
     * @Route("/{id}/conference", name="public_conference_show")
     * @Template()
     */
    public function showAction(Conference $conference) {
        $user = $this->getUser();
        $joined = null;
        $em = $this->getDoctrine()
                ->getManager()
        ;

        if ($user) {
            $criteria = [
                'conference' => $conference,
                'user' => $user,
            ];
            $joined = $em->getRepository('ConferenceSchedulerBundle:ConferenceUser')
                    ->findOneBy($criteria);
        }

        $totalUsers = $em->getRepository('ConferenceSchedulerBundle:ConferenceUser')
                ->countByConference($conference);

        return [
            'conference' => $conference,
            'joined' => $joined,
            'totalUsers' => $totalUsers,
        ];
    }

    /**
     * @Security("has_role('ROLE_USER')")
     * @Route("/{id}/join", name="public_conference_join")
     */
    public function joinAction(Conference $conference) {
        $user = $this->getUser();
        $coins = $user->getCoins() - $conference->getPrice();
        if ($coins < 0) {
            $this->addFlash('notice', 'You don\'t have enough coins');

            goto redirectToConference;
        }

        $em = $this->getDoctrine()
                ->getManager()
        ;

        $criteria = [
            'conference' => $conference,
            'user' => $user,
        ];
        $exists = $em->getRepository('ConferenceSchedulerBundle:ConferenceUser')
                ->findOneBy($criteria);

        if ($exists) {
            $this->addFlash('notice', 'You have already joined');

            goto redirectToConference;
        }

        $limit = $conference->getHall()->getUserLimit();
        $totalUsers = $em->getRepository('ConferenceSchedulerBundle:ConferenceUser')
                ->countByConference($conference);

        // check for user limit of hall
        if ($totalUsers >= $limit) {
            $this->addFlash('notice', 'You have reached the limit of the hall');

            goto redirectToConference;
        }

        $user->setCoins($coins);


        $conferenceUser = new ConferenceUser;
        $conferenceUser->setConference($conference);
        $conferenceUser->setUser($user);

        $conference->addUser($conferenceUser);

        $em->flush();

        // dispatch event
        $event = new ConferenceEvent($conference, $user);
        $this->get('event_dispatcher')
                ->dispatch(ConferenceEvent::EVENT_USER_ADD, $event);

        redirectToConference: {
            return $this->redirectToRoute('public_conference_show', [
                        'id' => $conference->getId(),
            ]);
        }
    }

    /**
     * @Route("/halls", name="public_halls")
     * @Template()
     */
    public function hallsAction() {
        $halls = $this->getDoctrine()
                ->getManager()
                ->getRepository('ConferenceSchedulerBundle:Hall')
                ->findAll();

        return [
            'halls' => $halls,
        ];
    }

}
