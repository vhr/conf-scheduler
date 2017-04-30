<?php

namespace ConferenceSchedulerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Hall
 *
 * @ORM\Table(name="hall")
 * @ORM\Entity(repositoryClass="ConferenceSchedulerBundle\Repository\HallRepository")
 */
class Hall {

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
     * @var int
     *
     * @ORM\Column(name="userLimit", type="smallint")
     */
    private $userLimit;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="ConferenceSchedulerBundle\Entity\Venue")
     * @ORM\JoinColumn(name="venue_id", referencedColumnName="id")
     */
    private $venue;

    /**
     * @ORM\ManyToMany(targetEntity="ConferenceSchedulerBundle\Entity\Goods", cascade={"persist"})
     * @ORM\JoinTable(name="hall_goods",
     *      joinColumns={@ORM\JoinColumn(name="hall_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="goods_id", referencedColumnName="id", unique=true)}
     * )
     */
    private $goods;

    /**
     * Construct
     */
    public function __construct() {
        $this->goods = new ArrayCollection();
    }

    /**
     * To string
     * 
     * @return string
     */
    public function __toString() {
        return $this->name;
    }

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
     * Set name
     *
     * @param string $name
     *
     * @return Hall
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
     * Set userLimit
     *
     * @param integer $userLimit
     *
     * @return Hall
     */
    public function setUserLimit($userLimit) {
        $this->userLimit = $userLimit;

        return $this;
    }

    /**
     * Get userLimit
     *
     * @return int
     */
    public function getUserLimit() {
        return $this->userLimit;
    }

    /**
     * Set venue
     *
     * @param \ConferenceSchedulerBundle\Entity\Venue $venue
     *
     * @return Hall
     */
    public function setVenue(\ConferenceSchedulerBundle\Entity\Venue $venue = null) {
        $this->venue = $venue;

        return $this;
    }

    /**
     * Get venue
     *
     * @return \ConferenceSchedulerBundle\Entity\Venue
     */
    public function getVenue() {
        return $this->venue;
    }

    /**
     * Add good
     *
     * @param \ConferenceSchedulerBundle\Entity\Goods $good
     *
     * @return Hall
     */
    public function addGood(\ConferenceSchedulerBundle\Entity\Goods $good) {
        $this->goods[] = $good;

        return $this;
    }

    /**
     * Remove good
     *
     * @param \ConferenceSchedulerBundle\Entity\Goods $good
     */
    public function removeGood(\ConferenceSchedulerBundle\Entity\Goods $good) {
        $this->goods->removeElement($good);
    }

    /**
     * Get goods
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getGoods() {
        return $this->goods;
    }

    /**
     * Set image
     *
     * @param string $image
     *
     * @return Hall
     */
    public function setImage($image) {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage() {
        return $this->image;
    }


    /**
     * Set description
     *
     * @param string $description
     *
     * @return Hall
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
}
