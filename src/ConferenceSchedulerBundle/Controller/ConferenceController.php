<?php

namespace ConferenceSchedulerBundle\Controller;

use ConferenceSchedulerBundle\Entity\Conference;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use ConferenceSchedulerBundle\Form\ConferenceType;
use ConferenceSchedulerBundle\Event\ConferenceEvent;
use ConferenceSchedulerBundle\Entity\ConferenceAdmin;
use DateTime;

/**
 * Conference controller.
 *
 * @Route("conference")
 */
class ConferenceController extends Controller {

    /**
     * Lists all conference entities.
     *
     * @Route("/", name="conference_index")
     * @Method("GET")
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
     * Creates a new conference entity.
     *
     * @Route("/new", name="conference_new")
     * @Method({"GET", "POST"})
     * @Template()
     */
    public function newAction(Request $request) {
        $conference = new Conference();
        $form = $this->createForm(ConferenceType::class, $conference);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $role = $em->getRepository('ConferenceSchedulerBundle:Role')->findOneBy([
                'role' => ConferenceAdmin::ROLE_CONFERENCE_OWNER,
            ]);

            $admin = new ConferenceAdmin;
            $admin->setUser($this->getUser());
            $admin->setConference($conference);
            $admin->setRole($role);

            $conference->addAdmin($admin);
            $em->persist($conference);
            $em->flush();

            return $this->redirectToRoute('conference_show', array('id' => $conference->getId()));
        }

        return [
            'conference' => $conference,
            'form' => $form->createView(),
        ];
    }

    /**
     * Finds and displays a conference entity.
     *
     * @Route("/{id}", name="conference_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction(Conference $conference) {
        $deleteForm = $this->createDeleteForm($conference);

        return [
            'conference' => $conference,
            'delete_form' => $deleteForm->createView(),
        ];
    }

    /**
     * Displays a form to edit an existing conference entity.
     *
     * @Route("/{id}/edit", name="conference_edit")
     * @Method({"GET", "POST"})
     * @Template()
     */
    public function editAction(Request $request, Conference $conference) {
        $deleteForm = $this->createDeleteForm($conference);
        $editForm = $this->createForm(ConferenceType::class, $conference);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('conference_edit', array('id' => $conference->getId()));
        }

        return [
            'conference' => $conference,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ];
    }

    /**
     * Deletes a conference entity.
     *
     * @Route("/{id}", name="conference_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Conference $conference) {
        $form = $this->createDeleteForm($conference);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($conference);
            $em->flush();
        }

        return $this->redirectToRoute('conference_index');
    }

    /**
     * Deletes a conference entity.
     *
     * @Route("/{id}/dismiss", name="conference_dismiss")
     * @Method("GET")
     */
    public function dismissAction(Conference $conference) {
        $deleted = new DateTime;
        $conference->setDeleted($deleted);

        // dispatch event
        $event = new ConferenceEvent($conference, $this->getUser());
        $this->get('event_dispatcher')
                ->dispatch(ConferenceEvent::EVENT_DISMISS, $event);

        $this->getDoctrine()
                ->getManager()
                ->flush();

        return $this->redirectToRoute('conference_index');
    }

    /**
     * Creates a form to delete a conference entity.
     *
     * @param Conference $conference The conference entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Conference $conference) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('conference_delete', array('id' => $conference->getId())))
                        ->setMethod('DELETE')
                        ->getForm()
        ;
    }

}
