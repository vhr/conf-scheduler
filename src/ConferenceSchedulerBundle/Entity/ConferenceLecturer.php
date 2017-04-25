<?php

namespace ConferenceSchedulerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ConferenceLecturer
 *
 * @ORM\Table(name="conference_lecturer")
 * @ORM\Entity(repositoryClass="ConferenceSchedulerBundle\Repository\ConferenceLecturerRepository")
 */
class ConferenceLecturer {

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
     * @ORM\Column(name="status", type="smallint")
     */
    private $status;

    /**
     *
     * 
     * @ORM\ManyToOne(targetEntity="ConferenceSchedulerBundle\Entity\Conference", inversedBy="lecturers")
     * @ORM\JoinColumn(name="conference_id", referencedColumnName="id")
     */
    private $conference;

    /*
     * 
     * Auto generated
     * 
     */

    /**
     * Get id
     *
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set user
     *
     * @param \stdClass $user
     *
     * @return ConferenceLecturer
     */
    public function setUser($user) {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \stdClass
     */
    public function getUser() {
        return $this->user;
    }

    /**
     * Set curriculum
     *
     * @param \stdClass $curriculum
     *
     * @return ConferenceLecturer
     */
    public function setCurriculum($curriculum) {
        $this->curriculum = $curriculum;

        return $this;
    }

    /**
     * Get curriculum
     *
     * @return \stdClass
     */
    public function getCurriculum() {
        return $this->curriculum;
    }

    /**
     * Set status
     *
     * @param integer $status
     *
     * @return ConferenceLecturer
     */
    public function setStatus($status) {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return int
     */
    public function getStatus() {
        return $this->status;
    }


    /**
     * Set conference
     *
     * @param \ConferenceSchedulerBundle\Entity\Conference $conference
     *
     * @return ConferenceLecturer
     */
    public function setConference(\ConferenceSchedulerBundle\Entity\Conference $conference = null)
    {
        $this->conference = $conference;

        return $this;
    }

    /**
     * Get conference
     *
     * @return \ConferenceSchedulerBundle\Entity\Conference
     */
    public function getConference()
    {
        return $this->conference;
    }
}
