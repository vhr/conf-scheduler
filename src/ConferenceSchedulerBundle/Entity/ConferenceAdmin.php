<?php

namespace ConferenceSchedulerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ConferenceLecturer
 *
 * @ORM\Table(name="conference_admin")
 * @ORM\Entity(repositoryClass="ConferenceSchedulerBundle\Repository\ConferenceAdminRepository")
 */
class ConferenceAdmin {
    
    const ROLE_CONFERENCE_OWNER = 'ROLE_CONFERENCE_OWNER';
    const ROLE_CONFERENCE_ADMIN = 'ROLE_CONFERENCE_ADMIN';

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
     * @ORM\ManyToOne(targetEntity="ConferenceSchedulerBundle\Entity\Conference", inversedBy="admins")
     * @ORM\JoinColumn(name="conference_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $conference;

    /**
     * @var \ConferenceSchedulerBundle\Entity\Role
     *
     * @ORM\ManyToOne(targetEntity="ConferenceSchedulerBundle\Entity\Role")
     * @ORM\JoinColumn(name="role_id", referencedColumnName="id")
     */
    private $role;

    /**
     * Construct
     */
    public function __construct() {
//        $this->role = 0;
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
     * Set user
     *
     * @param \ConferenceSchedulerBundle\Entity\User $user
     *
     * @return ConferenceAdmin
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
     * @return ConferenceAdmin
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

    /**
     * Set role
     *
     * @param \ConferenceSchedulerBundle\Entity\Role $role
     *
     * @return ConferenceAdmin
     */
    public function setRole(\ConferenceSchedulerBundle\Entity\Role $role = null)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role
     *
     * @return \ConferenceSchedulerBundle\Entity\Role
     */
    public function getRole()
    {
        return $this->role;
    }
}
