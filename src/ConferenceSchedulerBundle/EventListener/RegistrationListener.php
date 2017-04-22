<?php

namespace ConferenceSchedulerBundle\EventListener;

use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FormEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * Listener responsible to change the redirection at the end of the password resetting
 */
class RegistrationListener implements EventSubscriberInterface {

    /**
     * @var UrlGeneratorInterface
     */
    private $router;

    /**
     * Construct
     * 
     * @param UrlGeneratorInterface $router
     */
    public function __construct(UrlGeneratorInterface $router) {
        $this->router = $router;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents() {
        return [
            FOSUserEvents::REGISTRATION_SUCCESS => [
                ['onRegistrationSuccess', -10],
            ],
        ];
    }

    public function onRegistrationSuccess(FormEvent $event) {
//        $url = $this->router->generate('homepage');

//        $event->setResponse(new RedirectResponse($url));
    }

}
