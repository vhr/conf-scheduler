<?php

namespace ConferenceSchedulerBundle\Controller;

use ConferenceSchedulerBundle\Entity\Venue;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use ConferenceSchedulerBundle\Form\VenueType;

/**
 * Venue controller.
 *
 * @Route("venue")
 */
class VenueController extends Controller {

    /**
     * Lists all venue entities.
     *
     * @Route("/", name="venue_index")
     * @Method("GET")
     * @Template()
     */
    public function indexAction(Request $request) {
        $query = $this->getDoctrine()
                ->getManager()
                ->getRepository('ConferenceSchedulerBundle:Venue')
                ->findAllByAccessQuery($this->getUser());

        $pagination = $this->get('knp_paginator')
                ->paginate($query, $request->query->getInt('page', 1))
        ;

        return [
            'pagination' => $pagination,
        ];
    }

    /**
     * Creates a new venue entity.
     *
     * @Route("/new", name="venue_new")
     * @Method({"GET", "POST"})
     * @Template()
     */
    public function newAction(Request $request) {
        $venue = new Venue();
        $form = $this->createForm(VenueType::class, $venue);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($venue);
            $em->flush();

            return $this->redirectToRoute('venue_show', array('id' => $venue->getId()));
        }

        return [
            'venue' => $venue,
            'form' => $form->createView(),
        ];
    }

    /**
     * Finds and displays a venue entity.
     *
     * @Route("/{id}", name="venue_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction(Venue $venue) {
        $deleteForm = $this->createDeleteForm($venue);

        return [
            'venue' => $venue,
            'delete_form' => $deleteForm->createView(),
        ];
    }

    /**
     * Displays a form to edit an existing venue entity.
     *
     * @Route("/{id}/edit", name="venue_edit")
     * @Method({"GET", "POST"})
     * @Template()
     */
    public function editAction(Request $request, Venue $venue) {
        $deleteForm = $this->createDeleteForm($venue);
        $editForm = $this->createForm(VenueType::class, $venue);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('venue_edit', array('id' => $venue->getId()));
        }

        return [
            'venue' => $venue,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ];
    }

    /**
     * Deletes a venue entity.
     *
     * @Route("/{id}", name="venue_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Venue $venue) {
        $form = $this->createDeleteForm($venue);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($venue);
            $em->flush();
        }

        return $this->redirectToRoute('venue_index');
    }

    /**
     * Creates a form to delete a venue entity.
     *
     * @param Venue $venue The venue entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Venue $venue) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('venue_delete', array('id' => $venue->getId())))
                        ->setMethod('DELETE')
                        ->getForm()
        ;
    }

}
