<?php

namespace ConferenceSchedulerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ConferenceLecturer
 *
 * @ORM\Table(name="conference_lecturer")
 * @ORM\Entity(repositoryClass="ConferenceSchedulerBundle\Repository\ConferenceLecturerRepository")
 */
class ConferenceLecturer
{
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
     * @var \stdClass
     *
     * @ORM\Column(name="curriculum", type="object")
     */
    private $curriculum;

    /**
     * @var int
     *
     * @ORM\Column(name="status", type="smallint")
     */
    private $status;


    /**
     * Get id
     *
     * @return int
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
     * @return ConferenceLecturer
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
     * Set curriculum
     *
     * @param \stdClass $curriculum
     *
     * @return ConferenceLecturer
     */
    public function setCurriculum($curriculum)
    {
        $this->curriculum = $curriculum;

        return $this;
    }

    /**
     * Get curriculum
     *
     * @return \stdClass
     */
    public function getCurriculum()
    {
        return $this->curriculum;
    }

    /**
     * Set status
     *
     * @param integer $status
     *
     * @return ConferenceLecturer
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }
}

