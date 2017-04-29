<?php

namespace ConferenceSchedulerBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use ConferenceSchedulerBundle\Entity\Conference;
use ConferenceSchedulerBundle\Entity\User;
use ConferenceSchedulerBundle\Entity\ConferenceProgram;

class ConferenceProgramEvent extends Event {

    // Program events
    const EVENT_ADD = 'conference.program.add';
    // Lecturer events
    const EVENT_LECTURER_ADD = 'conference.program.lecturer.add';
    const EVENT_LECTURER_DELETE = 'conference.program.lecturer.delete';

    /**
     * @var \ConferenceSchedulerBundle\Entity\Conference
     */
    protected $conference;

    /**
     * @var \ConferenceSchedulerBundle\Entity\User
     */
    protected $user;

    /**
     * @var \ConferenceSchedulerBundle\Entity\ConferenceProgram
     */
    protected $conferenceProgram;

    /**
     * Construct
     * 
     * @param Conference $conference
     * @param User $user
     * @param ConferenceProgram $program
     */
    public function __construct(Conference $conference, User $user, ConferenceProgram $program) {
        $this->conference = $conference;
        $this->user = $user;
        $this->conferenceProgram = $program;
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

    /**
     * @return \ConferenceSchedulerBundle\Entity\ConferenceProgram
     */
    public function getConferenceProgram() {
        return $this->conferenceProgram;
    }

}
