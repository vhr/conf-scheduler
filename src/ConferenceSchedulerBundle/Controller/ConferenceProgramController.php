<?php

namespace ConferenceSchedulerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use ConferenceSchedulerBundle\Form\ConferenceProgramType;
use ConferenceSchedulerBundle\Entity\ConferenceProgram;
use ConferenceSchedulerBundle\Entity\Conference;
use ConferenceSchedulerBundle\Entity\User;

/**
 * Conference users controller.
 *
 * @Route("conference/{conference_id}/program")
 */
class ConferenceProgramController extends Controller {

    /**
     * Program event of conference
     *
     * @Route("/", name="conference_program_index")
     * @Method("GET")
     * @Template()
     * @ParamConverter("conference", class="ConferenceSchedulerBundle:Conference", options={"id"="conference_id"})
     */
    public function indexAction(Conference $conference) {
        $em = $this->getDoctrine()->getManager();

        $program = $conference->getPrograms();

        return [
            'conference' => $conference,
            'program' => $program,
        ];
    }

    /**
     * Creates a new conference entity.
     *
     * @Route("/new", name="conference_program_new")
     * @Method({"GET", "POST"})
     * @Template()
     * @ParamConverter("conference", class="ConferenceSchedulerBundle:Conference", options={"id"="conference_id"})
     */
    public function newAction(Request $request, Conference $conference) {
        $conferenceProgram = new ConferenceProgram();
        $conferenceProgram->setConference($conference);

        $form = $this->createForm(ConferenceProgramType::class, $conferenceProgram);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($conferenceProgram);
            $em->flush();

            return $this->redirectToRoute('conference_program_index', [
                        'conference_id' => $conference->getId()
            ]);
        }

        return [
            'conference' => $conference,
            'conferenceProgram' => $conferenceProgram,
            'form' => $form->createView(),
        ];
    }

}
