<?php

namespace ConferenceSchedulerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use ConferenceSchedulerBundle\Entity\User;
use ConferenceSchedulerBundle\Entity\Conference;
use ConferenceSchedulerBundle\Entity\ConferenceLecturer;
use ConferenceSchedulerBundle\Entity\ConferenceProgram;
use ConferenceSchedulerBundle\Entity\ConferenceProgramLecturer;
use ConferenceSchedulerBundle\Event\ConferenceProgramEvent;

/**
 * Conference users controller.
 *
 * @Route("conference/{conference_id}/program/{program_id}/lecturers")
 */
class ConferenceProgramLecturerController extends Controller {

    /**
     * List of lecturers for event
     *
     * @Route("/", name="conference_program_lecturers")
     * @Method("GET")
     * @Template()
     * @ParamConverter("conference", class="ConferenceSchedulerBundle:Conference", options={"id"="conference_id"})
     * @ParamConverter("program", class="ConferenceSchedulerBundle:ConferenceProgram", options={"id"="program_id"})
     */
    public function indexAction(Conference $conference, ConferenceProgram $program) {
        // Get ordered lecturers (http://stackoverflow.com/a/16528722/4356973)
        $lecturers = $this->getDoctrine()
                ->getManager()
                ->getRepository('ConferenceSchedulerBundle:User')
                ->findAll();

        return [
            'conference' => $conference,
            'event' => $program,
        ];
    }

    /**
     * Lists all users that not lecturers
     *
     * @Route("/invite", name="conference_program_lecturer_invite")
     * @Method("GET")
     * @Template()
     * @ParamConverter("conference", class="ConferenceSchedulerBundle:Conference", options={"id"="conference_id"})
     * @ParamConverter("program", class="ConferenceSchedulerBundle:ConferenceProgram", options={"id"="program_id"})
     */
    public function inviteAction(Request $request, Conference $conference, ConferenceProgram $program) {
        $query = $this->getDoctrine()
                ->getManager()
                ->getRepository('ConferenceSchedulerBundle:ConferenceLecturer')
                ->findLecturerInConferenceQuery($program);

        $pagination = $this->get('knp_paginator')
                ->paginate($query, $request->query->getInt('page', 1))
        ;


        return [
            'conference' => $conference,
            'event' => $program,
            'pagination' => $pagination,
        ];
    }

    /**
     * Add user to conference
     *
     * @Route("/{id}/add", name="conference_program_lecturer_add")
     * @Method("GET")
     * @ParamConverter("conference", class="ConferenceSchedulerBundle:Conference", options={"id"="conference_id"})
     * @ParamConverter("program", class="ConferenceSchedulerBundle:ConferenceProgram", options={"id"="program_id"})
     */
    public function addAction(Conference $conference, ConferenceProgram $program, ConferenceLecturer $lecturer) {
        $em = $this->getDoctrine()
                ->getManager()
        ;
        $user = $lecturer->getUser();

        $criteria = [
            'program' => $program,
            'user' => $user,
        ];
        $programLecturer = $em->getRepository('ConferenceSchedulerBundle:ConferenceProgramLecturer')
                ->findOneBy($criteria)
        ;

        // check for collusion
        if ($programLecturer !== null) {
            $this->addFlash('notice', 'The lecturer is already added to event');

            goto redirectToList;
        }
        
        // check must visit
        $criteria = [
            'program' => $program,
            'mustVisit' => true,
        ];
        $programLecturer = $em->getRepository('ConferenceSchedulerBundle:ConferenceProgramLecturer')
                ->findOneBy($criteria)
        ;
        
        $mustVisit = $programLecturer === null ? true : false;

        $programLecturer = new ConferenceProgramLecturer;
        $programLecturer->setUser($user);
        $programLecturer->setProgram($program);
        $programLecturer->setMustVisit($mustVisit);

        $program->addLecturer($programLecturer);

        $em->flush();

        // dispatch event
        $event = new ConferenceProgramEvent($conference, $user, $program);
        $this->get('event_dispatcher')
                ->dispatch(ConferenceProgramEvent::EVENT_LECTURER_ADD, $event);

        // flashbag
        $this->addFlash('notice', 'Lecturer is added');

        redirectToList: {
            return $this->redirectToRoute('conference_program_lecturer_invite', [
                        'conference_id' => $conference->getId(),
                        'program_id' => $program->getId(),
            ]);
        }
    }

    /**
     * Remove user from conference
     *
     * @Route("/{id}/remove", name="conference_program_lecturer_delete")
     * @Method("GET")
     * @ParamConverter("conference", class="ConferenceSchedulerBundle:Conference", options={"id"="conference_id"})
     * @ParamConverter("program", class="ConferenceSchedulerBundle:ConferenceProgram", options={"id"="program_id"})
     */
    public function deleteAction(Conference $conference, ConferenceProgram $program, ConferenceProgramLecturer $lecturer) {
        $user = $lecturer->getUser();

        $em = $this->getDoctrine()->getManager();

        $em->remove($lecturer);
        $em->flush();

        // dispatch event
        $event = new ConferenceProgramEvent($conference, $user, $program);
        $this->get('event_dispatcher')
                ->dispatch(ConferenceProgramEvent::EVENT_LECTURER_DELETE, $event);

        // flashbag
        $this->addFlash('notice', 'Lecturer has removed from event');

        return $this->redirectToRoute('conference_program_lecturers', [
                    'conference_id' => $conference->getId(),
                    'program_id' => $program->getId(),
        ]);
    }

}
