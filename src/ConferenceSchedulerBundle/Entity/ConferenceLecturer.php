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

    const STATUS_ACTIVE = 1;
    const STATUS_PENDING = 2;
    const STATUS_REJECTED = 3;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \ConferenceSchedulerBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="ConferenceSchedulerBundle\Entity\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @var int
     *
     * @ORM\Column(name="status", type="smallint")
     */
    private $status;

    /**
     * @var \ConferenceSchedulerBundle\Entity\Conference
     * 
     * @ORM\ManyToOne(targetEntity="ConferenceSchedulerBundle\Entity\Conference", inversedBy="lecturers")
     * @ORM\JoinColumn(name="conference_id", referencedColumnName="id")
     */
    private $conference;

    /**
     * Construct
     */
    public function __construct() {
        $this->status = static::STATUS_PENDING;
    }

    /**
     * Get status name
     * 
     * @return string
     */
    public function getStatusName() {
        $name = '';

        switch ($this->status) {
            case static::STATUS_ACTIVE:
                $name = 'Active';
                break;
            case static::STATUS_PENDING:
                $name = 'Pending';
                break;
            case static::STATUS_REJECTED:
                $name = 'Rejected';
                break;
        }

        return $name;
    }

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
     * @return integer
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
    public function setConference(\ConferenceSchedulerBundle\Entity\Conference $conference = null) {
        $this->conference = $conference;

        return $this;
    }

    /**
     * Get conference
     *
     * @return \ConferenceSchedulerBundle\Entity\Conference
     */
    public function getConference() {
        return $this->conference;
    }

}
