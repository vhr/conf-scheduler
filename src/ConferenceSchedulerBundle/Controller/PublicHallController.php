<?php

namespace ConferenceSchedulerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class PublicHallController extends Controller {

    /**
     * @Route("/halls", name="public_halls")
     * @Template()
     */
    public function indexAction() {
        $halls = $this->getDoctrine()
                ->getManager()
                ->getRepository('ConferenceSchedulerBundle:Hall')
                ->findAll();

        return [
            'halls' => $halls,
        ];
    }

}
