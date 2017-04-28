<?php

namespace ConferenceSchedulerBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use ConferenceSchedulerBundle\Entity\Conference;
use ConferenceSchedulerBundle\Entity\User;

class ConferenceEvent extends Event {

    const EVENT_DISMISS = 'conference.dismiss';

    /**
     * @var \ConferenceSchedulerBundle\Entity\Conference
     */
    protected $conference;

    /**
     * @var \ConferenceSchedulerBundle\Entity\User
     */
    protected $user;

    /**
     * Construct
     * 
     * @param Conference $conference
     * @param User $user
     */
    public function __construct(Conference $conference, User $user) {
        $this->conference = $conference;
        $this->user = $user;
    }

    /**
     * @return \ConferenceSchedulerBundle\Entity\Conference
     */
    public function getConference() {
        return $this->conference;
    }

    /**
     * @return \ConferenceSchedulerBundle\Entity\User
     */
    public function getUser() {
        return $this->user;
    }

}
