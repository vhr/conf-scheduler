<?php

namespace ConferenceSchedulerBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use DateTime;

/**
 * User
 *
 * @ORM\Table(name="fos_user")
 * @ORM\Entity(repositoryClass="ConferenceSchedulerBundle\Repository\UserRepository")
 */
class User extends BaseUser {

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @Assert\NotBlank(message="Please enter your name.", groups={"Registration", "Profile"})
     * @Assert\Length(
     *     min=3,
     *     max=255,
     *     minMessage="The name is too short.",
     *     maxMessage="The name is too long.",
     *     groups={"Registration", "Profile"}
     * )
     */
    protected $name;

    /**
     * @var int
     *
     * @ORM\Column(name="coins", type="smallint", options={"default" : 1000})
     */
    private $coins;

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
     * Construct
     */
    public function __construct() {
        parent::__construct();

        $this->setCreated(new DateTime);
        $this->setUpdated(new DateTime);
    }

    /**
     * Get names
     * 
     * @return string
     */
    public function getNames() {
        if ($this->name) {
            return $this->name;
        } elseif ($this->username) {
            return $this->username;
        }

        return $this->email;
    }

    /**
     * Get either a Gravatar URL or complete image tag for user.
     * 
     * @param $size
     * @return string
     * @source https://gravatar.com/site/implement/images/php/
     */
    public function getGravatar($size = 32) {
        $slug = substr(md5("{$this->email}|{$this->username}"), 0, 12);
        $url = "https://robohash.org/{$slug}.png?bgset=bg1&size={$size}x{$size}";

//        $url = "https://www.gravatar.com/avatar/" . md5(strtolower(trim($this->email))) . "?s={$size}";

        return $url;
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
     * Set created
     *
     * @param \DateTime $created
     *
     * @return User
     */
    public function setCreated($created) {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated() {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     *
     * @return User
     */
    public function setUpdated($updated) {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime
     */
    public function getUpdated() {
        return $this->updated;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return User
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
     * Set coins
     *
     * @param integer $coins
     *
     * @return User
     */
    public function setCoins($coins)
    {
        $this->coins = $coins;

        return $this;
    }

    /**
     * Get coins
     *
     * @return integer
     */
    public function getCoins()
    {
        return $this->coins;
    }
}
