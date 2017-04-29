<?php

namespace ConferenceSchedulerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ConferenceLecturer
 *
 * @ORM\Table(name="conference_program_lecturer")
 * @ORM\Entity(repositoryClass="ConferenceSchedulerBundle\Repository\ConferenceLecturerRepository")
 */
class ConferenceProgramLecturer {

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \stdClass
     *
     * @ORM\Column(name="user", type="object")
     */
    private $user;

    /**
     * @var int
     *
     * @ORM\Column(name="must_visit", type="boolean", nullable=true)
     */
    private $mustVisit;

    /**
     * @var \ConferenceSchedulerBundle\Entity\ConferenceProgram[]
     * 
     * @ORM\ManyToOne(targetEntity="ConferenceSchedulerBundle\Entity\ConferenceProgram", inversedBy="lecturers")
     * @ORM\JoinColumn(name="lecturer_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $program;

    /*
     * 
     * Auto generated
     * 
     */

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set user
     *
     * @param \stdClass $user
     *
     * @return ConferenceProgramLecturer
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \stdClass
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set mustVisit
     *
     * @param boolean $mustVisit
     *
     * @return ConferenceProgramLecturer
     */
    public function setMustVisit($mustVisit)
    {
        $this->mustVisit = $mustVisit;

        return $this;
    }

    /**
     * Get mustVisit
     *
     * @return boolean
     */
    public function getMustVisit()
    {
        return $this->mustVisit;
    }

    /**
     * Set program
     *
     * @param \ConferenceSchedulerBundle\Entity\ConferenceProgram $program
     *
     * @return ConferenceProgramLecturer
     */
    public function setProgram(\ConferenceSchedulerBundle\Entity\ConferenceProgram $program = null)
    {
        $this->program = $program;

        return $this;
    }

    /**
     * Get program
     *
     * @return \ConferenceSchedulerBundle\Entity\ConferenceProgram
     */
    public function getProgram()
    {
        return $this->program;
    }
}
