<?php

namespace ConferenceSchedulerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use ConferenceSchedulerBundle\Entity\Conference;

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

        return [
            'conference' => $conference,
        ];
    }

    /**
     * @Route("/schedule", name="public_schedule")
     * @Template()
     */
    public function scheduleAction() {
//        $conferences = $this->getDoctrine()
//                ->getManager()
//                ->getRepository('ConferenceSchedulerBundle:Conference')
//                ->findAll();

        return [
//            'conferences' => $conferences,
        ];
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

    /*     *
     * @Method({"GET"})
     * @Route("/")
     * @Template()
     * /
      public function indexAction() {
      $entities = $this->getDoctrine()
      ->getManager()
      ->getRepository('ConferenceSchedulerBundle:Conference')
      ->findAll();

      return [
      'conferences' => $entities,
      ];
      }

      /* *
     * @Method({"GET"})
     * @Route("/conference/open", name="conference_open")
     * @Template()
     * /
      public function openAction() {
      $entities = $this->getDoctrine()
      ->getManager()
      ->getRepository('ConferenceSchedulerBundle:Conference')
      ->findAll();

      return [
      'conferences' => $entities,
      ];
      }

      /* *
     * @Method({"GET"})
     * @Route("/conference/particular", name="conference_particular")
     * @Template()
     * /
      public function particularAction() {
      $entities = $this->getDoctrine()
      ->getManager()
      ->getRepository('ConferenceSchedulerBundle:Conference')
      ->findAll();

      return [
      'conferences' => $entities,
      ];
      } */
}
