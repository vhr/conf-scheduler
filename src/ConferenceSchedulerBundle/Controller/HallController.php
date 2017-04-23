<?php

namespace ConferenceSchedulerBundle\Controller;

use ConferenceSchedulerBundle\Entity\Hall;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use ConferenceSchedulerBundle\Entity\Venue;
use ConferenceSchedulerBundle\Form\HallType;

/**
 * Hall controller.
 *
 * @Route("venue/{venue_id}/hall")
 */
class HallController extends Controller {

    /**
     * Lists all hall entities.
     *
     * @Route("/", name="hall_index")
     * @Method("GET")
     * @Template()
     * @ParamConverter("venue", class="ConferenceSchedulerBundle:Venue", options={"id"="venue_id"})
     */
    public function indexAction(Venue $venue) {
        $em = $this->getDoctrine()->getManager();

        $halls = $em->getRepository('ConferenceSchedulerBundle:Hall')
                ->findByVenue($venue->getId());

        return [
            'venue' => $venue,
            'halls' => $halls,
        ];
    }

    /**
     * Creates a new hall entity.
     *
     * @Route("/new", name="hall_new")
     * @Method({"GET", "POST"})
     * @ParamConverter("venue", class="ConferenceSchedulerBundle:Venue", options={"id"="venue_id"})
     * @Template()
     */
    public function newAction(Request $request, Venue $venue) {
        $hall = new Hall();
        $hall->setVenue($venue);
        $form = $this->createForm(HallType::class, $hall);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($hall);
            $em->flush();

            return $this->redirectToRoute('hall_show', [
                        'venue_id' => $venue->getId(),
                        'id' => $hall->getId()
            ]);
        }

        return [
            'venue' => $venue,
            'hall' => $hall,
            'form' => $form->createView(),
        ];
    }

    /**
     * Finds and displays a hall entity.
     *
     * @Route("/{id}", name="hall_show")
     * @Method("GET")
     * @ParamConverter("venue", class="ConferenceSchedulerBundle:Venue", options={"id"="venue_id"})
     * @Template()
     */
    public function showAction(Venue $venue, Hall $hall) {
        $deleteForm = $this->createDeleteForm($venue, $hall);

        return [
            'venue' => $venue,
            'hall' => $hall,
            'delete_form' => $deleteForm->createView(),
        ];
    }

    /**
     * Displays a form to edit an existing hall entity.
     *
     * @Route("/{id}/edit", name="hall_edit")
     * @Method({"GET", "POST"})
     * @ParamConverter("venue", class="ConferenceSchedulerBundle:Venue", options={"id"="venue_id"})
     * @Template()
     */
    public function editAction(Request $request, Venue $venue, Hall $hall) {
        $deleteForm = $this->createDeleteForm($venue, $hall);
        $editForm = $this->createForm(HallType::class, $hall);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('hall_edit', [
                        'venue_id' => $venue->getId(),
                        'id' => $hall->getId()
            ]);
        }

        return [
            'venue' => $venue,
            'hall' => $hall,
            'form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ];
    }

    /**
     * Deletes a hall entity.
     *
     * @Route("/{id}", name="hall_delete")
     * @Method("DELETE")
     * @ParamConverter("venue", class="ConferenceSchedulerBundle:Venue", options={"id"="venue_id"})
     */
    public function deleteAction(Request $request, Hall $hall, Venue $venue) {
        $form = $this->createDeleteForm($venue, $hall);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($hall);
            $em->flush();
        }

        return $this->redirectToRoute('hall_index', [
                    'venue_id' => $venue->getId(),
        ]);
    }

    /**
     * Creates a form to delete a hall entity.
     *
     * @param Hall $hall The hall entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Venue $venue, Hall $hall) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('hall_delete', [
                                    'venue_id' => $venue->getId(),
                                    'id' => $hall->getId()
                        ]))
                        ->setMethod('DELETE')
                        ->getForm()
        ;
    }

}
