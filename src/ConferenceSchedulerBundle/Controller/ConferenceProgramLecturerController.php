<?php

namespace ConferenceSchedulerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use ConferenceSchedulerBundle\Entity\User;
use ConferenceSchedulerBundle\Entity\Conference;
use ConferenceSchedulerBundle\Entity\ConferenceProgram;
use ConferenceSchedulerBundle\Entity\ConferenceProgramLecturer;

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
        $lecturers = $this->getDoctrine()
                ->getManager()
                ->getRepository('ConferenceSchedulerBundle:User')
                ->findAll();

        return [
            'conference' => $conference,
            'program' => $program,
            'lecturers' => $lecturers,
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
    public function addAction(Conference $conference, ConferenceProgram $program, User $user) {
        $em = $this->getDoctrine()->getManager();

        $lecturer = new ConferenceProgramLecturer;
        $lecturer->setUser($user);
        $lecturer->setProgram($program);

        $program->addLecturer($lecturer);

        $em->flush();

        return $this->redirectToRoute('conference_program_lecturers', [
                    'conference_id' => $conference->getId(),
                    'program_id' => $program->getId(),
        ]);
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
        $em = $this->getDoctrine()->getManager();

        $em->remove($lecturer);
        $em->flush();

        return $this->redirectToRoute('conference_program_lecturers', [
                    'conference_id' => $conference->getId(),
                    'program_id' => $program->getId(),
        ]);
    }

}
