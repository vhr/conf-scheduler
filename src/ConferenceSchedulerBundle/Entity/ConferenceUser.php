<?php

namespace ConferenceSchedulerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ConferenceUser
 *
 * @ORM\Table(name="conference_user2")
 * @ORM\Entity(repositoryClass="ConferenceSchedulerBundle\Repository\ConferenceUserRepository")
 */
class ConferenceUser {

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
     * @return ConferenceUser
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
     * @return ConferenceUser
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

}
