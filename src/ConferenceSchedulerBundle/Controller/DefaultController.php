<?php

namespace ConferenceSchedulerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        return $this->render('ConferenceSchedulerBundle:Default:index.html.twig');
    }

    /* *
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
    }*/
}
