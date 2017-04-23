<?php

namespace ConferenceSchedulerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class SecurityController extends Controller
{
    /**
     * @ Route("/login")
     */
    public function loginAction()
    {
        return $this->render('ConferenceSchedulerBundle:Security:login.html.twig', array(
            // ...
        ));
    }

    /**
     * @Route("/signup")
     */
    public function signupAction()
    {
        return $this->render('ConferenceSchedulerBundle:Security:signup.html.twig', array(
            // ...
        ));
    }

}
