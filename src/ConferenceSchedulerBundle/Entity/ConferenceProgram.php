<?php

namespace ConferenceSchedulerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * ConferenceProgram
 *
 * @ORM\Table(name="conference_program")
 * @ORM\Entity(repositoryClass="ConferenceSchedulerBundle\Repository\ConferenceProgramRepository")
 */
class ConferenceProgram {

    const TYPE_LECTURE = 1;
    const TYPE_BREAK = 2;
    const TYPES = [
        'Lecture' => self::TYPE_LECTURE,
        'Break' => self::TYPE_BREAK,
    ];

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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="start", type="time", nullable=true)
     */
    private $start;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="end", type="time", nullable=true)
     */
    private $end;

    /**
     * @var int
     *
     * @ORM\Column(name="type", type="smallint")
     */
    private $type;

    /**
     * @var \ConferenceSchedulerBundle\Entity\ConferenceProgramLecturer[]
     * 
     * @ORM\OneToMany(targetEntity="ConferenceSchedulerBundle\Entity\ConferenceProgramLecturer", mappedBy="program", cascade={"persist", "remove"})
     * @ORM\OrderBy({"mustVisit"="DESC"})
     */
    private $lecturers;

    /**
     * @var \ConferenceSchedulerBundle\Entity\Conference
     * 
     * @ORM\ManyToOne(targetEntity="ConferenceSchedulerBundle\Entity\Conference", inversedBy="programs")
     * @ORM\JoinColumn(name="conference_id", referencedColumnName="id")
     */
    private $conference;

    /**
     * Constructor
     */
    public function __construct() {
        $this->lecturers = new ArrayCollection;
        $this->type = static::TYPE_LECTURE;
    }

    /**
     * Is it event is a break
     * 
     * @return bool
     */
    public function isBreak() {
        $result = $this->type === static::TYPE_BREAK;
        
        return $result;
    }

    /**
     * Get array of lecturers names
     * 
     * @return array
     */
    public function getLecturersList() {
        $names = [];

        foreach ($this->lecturers as $lecturer) {
            $names[] = $lecturer->getUser()->getNames();
        }

        return $names;
    }

    /**
     * Get type like string
     * 
     * @return string
     */
    public function getTypeName() {
        $name = '';

        switch ($this->type) {
            case static::TYPE_LECTURE:
                $name = 'Lecture';
                break;
            case static::TYPE_BREAK:
                $name = 'Break';
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
     * Set name
     *
     * @param string $name
     *
     * @return ConferenceProgram
     */
    public function setName($name) {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return ConferenceProgram
     */
    public function setDescription($description) {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * Set start
     *
     * @param \DateTime $start
     *
     * @return ConferenceProgram
     */
    public function setStart($start) {
        $this->start = $start;

        return $this;
    }

    /**
     * Get start
     *
     * @return \DateTime
     */
    public function getStart() {
        return $this->start;
    }

    /**
     * Set end
     *
     * @param \DateTime $end
     *
     * @return ConferenceProgram
     */
    public function setEnd($end) {
        $this->end = $end;

        return $this;
    }

    /**
     * Get end
     *
     * @return \DateTime
     */
    public function getEnd() {
        return $this->end;
    }

    /**
     * Set type
     *
     * @param integer $type
     *
     * @return ConferenceProgram
     */
    public function setType($type) {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return integer
     */
    public function getType() {
        return $this->type;
    }

    /**
     * Set conference
     *
     * @param \ConferenceSchedulerBundle\Entity\Conference $conference
     *
     * @return ConferenceProgram
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

    /**
     * Add lecturer
     *
     * @param \ConferenceSchedulerBundle\Entity\ConferenceProgramLecturer $lecturer
     *
     * @return ConferenceProgram
     */
    public function addLecturer(\ConferenceSchedulerBundle\Entity\ConferenceProgramLecturer $lecturer) {
        $this->lecturers[] = $lecturer;

        return $this;
    }

    /**
     * Remove lecturer
     *
     * @param \ConferenceSchedulerBundle\Entity\ConferenceProgramLecturer $lecturer
     */
    public function removeLecturer(\ConferenceSchedulerBundle\Entity\ConferenceProgramLecturer $lecturer) {
        $this->lecturers->removeElement($lecturer);
    }

    /**
     * Get lecturers
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLecturers() {
        return $this->lecturers;
    }

}
