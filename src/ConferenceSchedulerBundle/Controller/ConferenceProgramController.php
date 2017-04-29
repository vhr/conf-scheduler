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
     * Finds and displays a conference entity.
     *
     * @Route("/{id}/show", name="conference_program_show")
     * @Method({"GET", "POST"})
     * @Template()
     * @ParamConverter("conference", class="ConferenceSchedulerBundle:Conference", options={"id"="conference_id"})
     */
    public function showAction(Conference $conference, ConferenceProgram $program) {
        $deleteForm = $this->createDeleteForm($program);

        return [
            'conference' => $conference,
            'program' => $program,
            'delete_form' => $deleteForm->createView(),
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
            'program' => $conferenceProgram,
            'form' => $form->createView(),
        ];
    }

    /**
     * Displays a form to edit an existing conference entity.
     *
     * @Route("/{id}/edit", name="conference_program_edit")
     * @Method({"GET", "POST"})
     * @Template()
     * @ParamConverter("conference", class="ConferenceSchedulerBundle:Conference", options={"id"="conference_id"})
     */
    public function editAction(Request $request, Conference $conference, ConferenceProgram $program) {
        $deleteForm = $this->createDeleteForm($program);
        $editForm = $this->createForm(ConferenceProgramType::class, $program);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('conference_program_edit', [
                        'conference_id' => $conference->getId(),
                        'id' => $program->getId()
            ]);
        }

        return [
            'conference' => $conference,
            'program' => $program,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ];
    }

    /**
     * Deletes a conference entity.
     *
     * @Route("/{id}", name="conference_program_delete")
     * @Method("DELETE")
     * @ParamConverter("conference", class="ConferenceSchedulerBundle:Conference", options={"id"="conference_id"})
     */
    public function deleteAction(Request $request, Conference $conference, ConferenceProgram $program) {
        $form = $this->createDeleteForm($program);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($program);
            $em->flush();
        }

        return $this->redirectToRoute('conference_program_index', [
                    'conference_id' => $conference->getId(),
        ]);
    }

    /**
     * Creates a form to delete a conference entity.
     *
     * @param Conference $conference The conference entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(ConferenceProgram $program) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('conference_program_delete', [
                                    'conference_id' => $program->getConference()->getId(),
                                    'id' => $program->getId()
                        ]))
                        ->setMethod('DELETE')
                        ->getForm()
        ;
    }

}
