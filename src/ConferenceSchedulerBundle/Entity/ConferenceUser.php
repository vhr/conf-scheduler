<?php

namespace ConferenceSchedulerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ConferenceLecturer
 *
 * @ORM\Table(name="conference_user")
 * @ORM\Entity(repositoryClass="ConferenceSchedulerBundle\Repository\ConferenceUserRepository")
 */
class ConferenceUser {

    /**
     * User is successfully joined to the conference
     */
    const STATUS_ACTIVE = 1;

    /**
     * System wait user to pay for conference
     */
    const STATUS_PENDING = 2;

    /**
     * The user will not visit the conference
     */
    const STATUS_REFUSED = 3;

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
     * @var \ConferenceSchedulerBundle\Entity\Conference
     * 
     * @ORM\ManyToOne(targetEntity="ConferenceSchedulerBundle\Entity\Conference", inversedBy="users")
     * @ORM\JoinColumn(name="conference_id", referencedColumnName="id")
     */
    private $conference;

    /**
     * @var int
     *
     * @ORM\Column(name="status", type="smallint")
     */
    private $status;

    // @todo add relation to payment transaction

    /**
     * Construct
     */
    public function __construct() {
        $this->status = static::STATUS_ACTIVE;
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
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set status
     *
     * @param integer $status
     *
     * @return ConferenceUser
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return integer
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set user
     *
     * @param \ConferenceSchedulerBundle\Entity\User $user
     *
     * @return ConferenceUser
     */
    public function setUser(\ConferenceSchedulerBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \ConferenceSchedulerBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set conference
     *
     * @param \ConferenceSchedulerBundle\Entity\Conference $conference
     *
     * @return ConferenceUser
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
