<?php

namespace ConferenceSchedulerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Conference
 *
 * @ORM\Table(name="conference")
 * @ORM\Entity(repositoryClass="ConferenceSchedulerBundle\Repository\ConferenceRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Conference {

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var int
     *
     * @ORM\Column(name="access", type="smallint", nullable=true)
     */
    private $access;

    /**
     * @var int
     *
     * @ORM\Column(name="price", type="decimal", precision=7, scale=2, nullable=true)
     */
    private $price;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=true)
     */
    private $date;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime")
     */
    private $created;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated", type="datetime")
     */
    private $updated;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="deleted", type="datetime", nullable=true)
     */
    private $deleted;

    /**
     * @var \ConferenceSchedulerBundle\Entity\Hall
     * , inversedBy="products"
     * 
     * @ORM\ManyToOne(targetEntity="ConferenceSchedulerBundle\Entity\Hall")
     * @ORM\JoinColumn(name="hall_id", referencedColumnName="id")
     */
    private $hall;

    /**
     * @var \ConferenceSchedulerBundle\Entity\ConferenceProgram[]
     * 
     * @ORM\OneToMany(targetEntity="ConferenceSchedulerBundle\Entity\ConferenceProgram", mappedBy="conference", cascade={"persist"})
     * @ORM\OrderBy({"start"="ASC"})
     */
    private $programs;

    /**
     * @var \ConferenceSchedulerBundle\Entity\ConferenceLecturer[]
     * 
     * @ORM\OneToMany(targetEntity="ConferenceSchedulerBundle\Entity\ConferenceLecturer", mappedBy="conference", cascade={"persist"})
     */
    private $lecturers;

    /**
     * @var \ConferenceSchedulerBundle\Entity\User[]
     * 
     * @ORM\ManyToMany(targetEntity="ConferenceSchedulerBundle\Entity\User")
     * @ORM\JoinTable(name="conference_admin",
     *      joinColumns={@ORM\JoinColumn(name="conference_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id", unique=true)}
     * )
     */
    private $admins;

    /**
     * @var \ConferenceSchedulerBundle\Entity\User[]
     * 
     * @ORM\ManyToMany(targetEntity="ConferenceSchedulerBundle\Entity\User")
     * @ORM\JoinTable(name="conference_user",
     *      joinColumns={@ORM\JoinColumn(name="conference_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id", unique=true)}
     * )
     */
    private $users;

    /**
     * Construct
     */
    public function __construct() {
        $this->created = new DateTime;
        $this->updated = new DateTime;
        $this->admins = new ArrayCollection;
        $this->lecturers = new ArrayCollection;
        $this->programs = new ArrayCollection;
    }

    /**
     * @ORM\PreUpdate()
     */
    public function preStore() {
        $this->updated = new DateTime;
    }

    /**
     * Get access with name
     * 
     * @return string
     */
    public function getAccessName() {
        $name = '';

        switch ($this->access) {
            case 1:
                $name = 'Open';
                break;
            case 2:
                $name = 'Particular';
                break;
        }

        return $name;
    }

    /**
     * Is conference has dismissed
     * 
     * @return bool
     */
    public function isDeleted() {
        $result = $this->deleted !== null ? true : false;

        return $result;
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
     * Set title
     *
     * @param string $title
     *
     * @return Conference
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Conference
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set access
     *
     * @param integer $access
     *
     * @return Conference
     */
    public function setAccess($access)
    {
        $this->access = $access;

        return $this;
    }

    /**
     * Get access
     *
     * @return integer
     */
    public function getAccess()
    {
        return $this->access;
    }

    /**
     * Set price
     *
     * @param string $price
     *
     * @return Conference
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Conference
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return Conference
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     *
     * @return Conference
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set deleted
     *
     * @param \DateTime $deleted
     *
     * @return Conference
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;

        return $this;
    }

    /**
     * Get deleted
     *
     * @return \DateTime
     */
    public function getDeleted()
    {
        return $this->deleted;
    }

    /**
     * Set hall
     *
     * @param \ConferenceSchedulerBundle\Entity\Hall $hall
     *
     * @return Conference
     */
    public function setHall(\ConferenceSchedulerBundle\Entity\Hall $hall = null)
    {
        $this->hall = $hall;

        return $this;
    }

    /**
     * Get hall
     *
     * @return \ConferenceSchedulerBundle\Entity\Hall
     */
    public function getHall()
    {
        return $this->hall;
    }

    /**
     * Add program
     *
     * @param \ConferenceSchedulerBundle\Entity\ConferenceProgram $program
     *
     * @return Conference
     */
    public function addProgram(\ConferenceSchedulerBundle\Entity\ConferenceProgram $program)
    {
        $this->programs[] = $program;

        return $this;
    }

    /**
     * Remove program
     *
     * @param \ConferenceSchedulerBundle\Entity\ConferenceProgram $program
     */
    public function removeProgram(\ConferenceSchedulerBundle\Entity\ConferenceProgram $program)
    {
        $this->programs->removeElement($program);
    }

    /**
     * Get programs
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPrograms()
    {
        return $this->programs;
    }

    /**
     * Add lecturer
     *
     * @param \ConferenceSchedulerBundle\Entity\ConferenceLecturer $lecturer
     *
     * @return Conference
     */
    public function addLecturer(\ConferenceSchedulerBundle\Entity\ConferenceLecturer $lecturer)
    {
        $this->lecturers[] = $lecturer;

        return $this;
    }

    /**
     * Remove lecturer
     *
     * @param \ConferenceSchedulerBundle\Entity\ConferenceLecturer $lecturer
     */
    public function removeLecturer(\ConferenceSchedulerBundle\Entity\ConferenceLecturer $lecturer)
    {
        $this->lecturers->removeElement($lecturer);
    }

    /**
     * Get lecturers
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLecturers()
    {
        return $this->lecturers;
    }

    /**
     * Add admin
     *
     * @param \ConferenceSchedulerBundle\Entity\User $admin
     *
     * @return Conference
     */
    public function addAdmin(\ConferenceSchedulerBundle\Entity\User $admin)
    {
        $this->admins[] = $admin;

        return $this;
    }

    /**
     * Remove admin
     *
     * @param \ConferenceSchedulerBundle\Entity\User $admin
     */
    public function removeAdmin(\ConferenceSchedulerBundle\Entity\User $admin)
    {
        $this->admins->removeElement($admin);
    }

    /**
     * Get admins
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAdmins()
    {
        return $this->admins;
    }

    /**
     * Add user
     *
     * @param \ConferenceSchedulerBundle\Entity\User $user
     *
     * @return Conference
     */
    public function addUser(\ConferenceSchedulerBundle\Entity\User $user)
    {
        $this->users[] = $user;

        return $this;
    }

    /**
     * Remove user
     *
     * @param \ConferenceSchedulerBundle\Entity\User $user
     */
    public function removeUser(\ConferenceSchedulerBundle\Entity\User $user)
    {
        $this->users->removeElement($user);
    }

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUsers()
    {
        return $this->users;
    }
}
