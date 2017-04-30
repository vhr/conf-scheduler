<?php

namespace ConferenceSchedulerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Venue
 *
 * @ORM\Table(name="venue")
 * @ORM\Entity(repositoryClass="ConferenceSchedulerBundle\Repository\VenueRepository")
 */
class Venue {

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
     * @ORM\Column(name="image", type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="text", nullable=true)
     */
    private $address;

    /**
     * @var \ConferenceSchedulerBundle\Entity\Hall[]
     * 
     * @ORM\OneToMany(targetEntity="ConferenceSchedulerBundle\Entity\Hall", mappedBy="venue", cascade={"persist"})
     * @ORM\OrderBy({"name"="ASC"})
     */
    private $halls;

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
     * @return Venue
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
     * Set address
     *
     * @param string $address
     *
     * @return Venue
     */
    public function setAddress($address) {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress() {
        return $this->address;
    }

    /**
     * Set image
     *
     * @param string $image
     *
     * @return Venue
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
     * Constructor
     */
    public function __construct()
    {
        $this->halls = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add hall
     *
     * @param \ConferenceSchedulerBundle\Entity\Hall $hall
     *
     * @return Venue
     */
    public function addHall(\ConferenceSchedulerBundle\Entity\Hall $hall)
    {
        $this->halls[] = $hall;

        return $this;
    }

    /**
     * Remove hall
     *
     * @param \ConferenceSchedulerBundle\Entity\Hall $hall
     */
    public function removeHall(\ConferenceSchedulerBundle\Entity\Hall $hall)
    {
        $this->halls->removeElement($hall);
    }

    /**
     * Get halls
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getHalls()
    {
        return $this->halls;
    }
}
