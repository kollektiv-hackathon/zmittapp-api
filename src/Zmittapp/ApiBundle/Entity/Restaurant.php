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
 * Restaurant
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Restaurant {

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
     * @ORM\ManyToMany(targetEntity="User", mappedBy="restaurants")
     * @Exclude
     **/
    private $users;

    /**
     * @var array
     *
     * @ORM\OneToMany(targetEntity="MenuItem", mappedBy="restaurant")
     * @Exclude
     *
     */
    private $menuItems;

    /**
     * @var string;
     *
     * @ORM\Column(name="name", type="string")
     * @Assert\NotBlank(message="Name is missing!")
     *
     */
    private $name;

    /**
     * @var string;
     *
     * @ORM\Column(name="phone", type="string")
     * @Assert\NotBlank(message="Phone is missing!")
     *
     */
    private $phone;

    /**
     * @var string;
     *
     * @ORM\Column(name="email", type="string")
     * @Assert\NotBlank(message="Email is missing!")
     *
     */
    private $email;

    /**
     * @var Decimal;
     *
     * @ORM\Column(name="lat", type="decimal")
     * @Assert\NotBlank(message="lat is missing!")
     *
     */
    private $lat;

    /**
     * @var Decimal;
     *
     * @ORM\Column(name="lon", type="decimal")
     * @Assert\NotBlank(message="long is missing!")
     *
     */
    private $lon;

    public function __construct() {
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set name
     *
     * @param string $name
     * @return Restaurant
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set phone
     *
     * @param string $phone
     * @return Restaurant
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string 
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Restaurant
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set lat
     *
     * @param string $lat
     * @return Restaurant
     */
    public function setLat($lat)
    {
        $this->lat = $lat;

        return $this;
    }

    /**
     * Get lat
     *
     * @return string 
     */
    public function getLat()
    {
        return $this->lat;
    }

    /**
     * Set lon
     *
     * @param string $lon
     * @return Restaurant
     */
    public function setLon($lon)
    {
        $this->lon = $lon;

        return $this;
    }

    /**
     * Get lon
     *
     * @return string 
     */
    public function getLon()
    {
        return $this->lon;
    }

    /**
     * Add users
     *
     * @param \Zmittapp\ApiBundle\Entity\User $users
     * @return Restaurant
     */
    public function addUser(\Zmittapp\ApiBundle\Entity\User $users)
    {
        $this->users[] = $users;

        return $this;
    }

    /**
     * Remove users
     *
     * @param \Zmittapp\ApiBundle\Entity\User $users
     */
    public function removeUser(\Zmittapp\ApiBundle\Entity\User $users)
    {
        $this->users->removeElement($users);
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

    /**
     * Add menuItems
     *
     * @param \Zmittapp\ApiBundle\Entity\MenuItem $menuItems
     * @return Restaurant
     */
    public function addMenuItem(\Zmittapp\ApiBundle\Entity\MenuItem $menuItems)
    {
        $this->menuItems[] = $menuItems;

        return $this;
    }

    /**
     * Remove menuItems
     *
     * @param \Zmittapp\ApiBundle\Entity\MenuItem $menuItems
     */
    public function removeMenuItem(\Zmittapp\ApiBundle\Entity\MenuItem $menuItems)
    {
        $this->menuItems->removeElement($menuItems);
    }

    /**
     * Get menuItems
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMenuItems()
    {
        return $this->menuItems;
    }
}
