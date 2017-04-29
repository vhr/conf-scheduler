<?php

namespace ConferenceSchedulerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller {

    /**
     * @Route("/", name="homepage")
     * @Template()
     */
    public function indexAction() {
        $conferences = $this->getDoctrine()
                ->getManager()
                ->getRepository('ConferenceSchedulerBundle:Conference')
                ->findAll();

        return [
            'conferences' => $conferences,
        ];
    }

    /**
     * @Route("/schedule", name="schedule_index")
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
