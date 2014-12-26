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
     * @Groups({"owner", "user"})
     *
     */
    private $id;

    /**
     * @ORM\ManyToMany(targetEntity="User", mappedBy="restaurants")
     *
     * @Exclude
     **/
    private $users;

    /**
     * @ORM\OneToOne(targetEntity="Zmittapp\AuthBundle\Entity\Owner", mappedBy="restaurant")
     *
     * @Groups({"owner"})
     *
     **/
    private $owner;

    /**
     * @var array
     *
     * @ORM\OneToMany(targetEntity="MenuItem", mappedBy="restaurant")
     *
     * @Exclude
     */
    private $menuItems;

    /**
     * @var string;
     *
     * @ORM\Column(name="name", type="string")
     * @Assert\NotBlank(message="Name is missing!")
     *
     * @Groups({"owner", "user"})
     *
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="text")
     * @Assert\NotBlank(message="Address is missing!")
     *
     * @Groups({"owner", "user"})
     */
    private $address;

    /**
     * @var string
     *
     * @ORM\Column(name="zip", type="string", length=5)
     * @Assert\NotBlank(message="Zip code is missing!")
     *
     * @Groups({"owner", "user"})
     */
    private $zip;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=255)
     * @Assert\NotBlank(message="City is missing!")
     *
     * @Groups({"owner", "user"})
     */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(name="country", type="string", length=255)
     * @Assert\NotBlank(message="Country is missing!")
     *
     * @Groups({"owner", "user"})
     */
    private $country;

    /**
     * @var string;
     *
     * @ORM\Column(name="phone", type="string")
     * @Assert\NotBlank(message="Phone is missing!")
     *
     * @Groups({"owner", "user"})
     */
    private $phone;

    /**
     * @var string;
     *
     * @ORM\Column(name="email", type="string")
     * @Assert\NotBlank(message="Email is missing!")
     *
     * @Groups({"owner", "user"})
     */
    private $email;

    /**
     * @var Decimal;
     *
     * @ORM\Column(name="lat", type="decimal", scale=7)
     * @Assert\NotBlank(message="lat is missing!")
     *
     * @Groups({"owner", "user"})
     *
     */
    private $lat;

    /**
     * @var Decimal;
     *
     * @ORM\Column(name="lon", type="decimal", scale=7)
     * @Assert\NotBlank(message="long is missing!")
     *
     * @Groups({"owner", "user"})
     */
    private $lon;

    public function __toString(){
        return $this->getName();
    }

    public function __construct() {
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function castToRestaurantLocation() {
        $obj = new RestaurantLocation();
        foreach (get_object_vars($this) as $key => $name) {
            $obj->$key = $name;
        }
        return $obj;
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

    /**
     * Set address
     *
     * @param string $address
     * @return Restaurant
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string 
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set zip
     *
     * @param string $zip
     * @return Restaurant
     */
    public function setZip($zip)
    {
        $this->zip = $zip;

        return $this;
    }

    /**
     * Get zip
     *
     * @return string 
     */
    public function getZip()
    {
        return $this->zip;
    }

    /**
     * Set city
     *
     * @param string $city
     * @return Restaurant
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string 
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set country
     *
     * @param string $country
     * @return Restaurant
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return string 
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set owner
     *
     * @param \Zmittapp\AuthBundle\Entity\Owner $owner
     * @return Restaurant
     */
    public function setOwner(\Zmittapp\AuthBundle\Entity\Owner $owner = null)
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * Get owner
     *
     * @return \Zmittapp\AuthBundle\Entity\Owner 
     */
    public function getOwner()
    {
        return $this->owner;
    }
}
