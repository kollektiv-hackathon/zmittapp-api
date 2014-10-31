<?php
/*
 * This file is part of the [name] package.
 *
 * (c) Marc Juchli <mail@marcjuch.li>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zmittapp\ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Exclude;
use Symfony\Component\Validator\Constraints as Assert;
use \DateTime;
use JMS\Serializer\Annotation\Groups;


/**
 * MenuItem
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class User {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     */
    private $id;

    /**
     * @var integer;
     *
     * @ORM\Column(name="uid", type="integer")
     * @Assert\NotBlank(message="UID is missing!")
     *
     */
    private $uid;

    /**
     * @ORM\ManyToMany(targetEntity="Restaurant", inversedBy="users")
     * @ORM\JoinTable(name="users_restaurants")
     **/
    private $restaurants;

    public function __construct() {
        $this->restaurants = new \Doctrine\Common\Collections\ArrayCollection();
    }


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
     * Set uid
     *
     * @param integer $uid
     * @return User
     */
    public function setUid($uid)
    {
        $this->uid = $uid;

        return $this;
    }

    /**
     * Get uid
     *
     * @return integer 
     */
    public function getUid()
    {
        return $this->uid;
    }

    /**
     * Add restaurants
     *
     * @param \Zmittapp\ApiBundle\Entity\Restaurant $restaurants
     * @return User
     */
    public function addRestaurant(\Zmittapp\ApiBundle\Entity\Restaurant $restaurants)
    {
        $this->restaurants[] = $restaurants;

        return $this;
    }

    /**
     * Remove restaurants
     *
     * @param \Zmittapp\ApiBundle\Entity\Restaurant $restaurants
     */
    public function removeRestaurant(\Zmittapp\ApiBundle\Entity\Restaurant $restaurants)
    {
        $this->restaurants->removeElement($restaurants);
    }

    /**
     * Get restaurants
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRestaurants()
    {
        return $this->restaurants;
    }
}
