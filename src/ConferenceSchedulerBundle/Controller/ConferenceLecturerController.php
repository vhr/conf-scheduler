<?php

namespace ConferenceSchedulerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use ConferenceSchedulerBundle\Entity\Conference;
use ConferenceSchedulerBundle\Entity\User;
use ConferenceSchedulerBundle\Entity\ConferenceLecturer;

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
        $em = $this->getDoctrine()->getManager();

        $lecturers = $conference->getLecturers();

        return [
            'conference' => $conference,
            'lecturers' => $lecturers,
        ];
    }

    /**
     * Add user to conference
     *
     * @Route("/add", name="conference_lecturer_add")
     * @Method("GET")
     * @Template()
     * @ParamConverter("conference", class="ConferenceSchedulerBundle:Conference", options={"id"="conference_id"})
     */
    public function addAction(Conference $conference) {
        $em = $this->getDoctrine()->getManager();
        
        $lecturer = new ConferenceLecturer;
        $lecturer->setConference($conference);
        $lecturer->setUser($this->getUser());

        $conference->addLecturer($lecturer);

        $em->flush();

        return $this->redirectToRoute('conference_lecturer_index', [
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

        return $this->redirectToRoute('conference_lecturer_index', [
                    'conference_id' => $conference->getId(),
        ]);
    }

}
