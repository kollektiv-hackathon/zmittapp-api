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
class MenuItem {

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
     * @ORM\ManyToOne(targetEntity="Restaurant", inversedBy="menuItems")
     * @ORM\JoinColumn(name="restaurant_id", referencedColumnName="id")
     *
     */
    private $restaurant;

    /**
     * @var string;
     *
     * @ORM\Column(name="appetizer", type="string")
     * @Assert\NotBlank(message="Appetizer is missing!")
     *
     */
    private $appetizer;

    /**
     * @var string;
     *
     * @ORM\Column(name="maincourse", type="string")
     * @Assert\NotBlank(message="Main course is missing!")
     *
     */
    private $mainCourse;

    /**
     * @var string;
     *
     * @ORM\Column(name="desert", type="string")
     * @Assert\NotBlank(message="Desert is missing!")
     *
     */
    private $desert;

    /**
     * @var string;
     *
     * @ORM\Column(name="price", type="decimal")
     * @Assert\NotBlank(message="Price is missing!")
     *
     */
    private $price;

    /**
     * @var date;
     *
     * @ORM\Column(name="date", type="date")
     * @Assert\Date()
     *
     */
    private $date;


    /**
     * @var Boolean;
     *
     * @ORM\Column(name="vegetarian", type="boolean", nullable=true)
     *
     */
    private $vegetarian;

    /**
     * @var Boolean;
     *
     * @ORM\Column(name="vegan", type="boolean", nullable=true)
     *
     */
    private $vegan;

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
     * Set appetizer
     *
     * @param string $appetizer
     * @return MenuItem
     */
    public function setAppetizer($appetizer)
    {
        $this->appetizer = $appetizer;

        return $this;
    }

    /**
     * Get appetizer
     *
     * @return string 
     */
    public function getAppetizer()
    {
        return $this->appetizer;
    }

    /**
     * Set mainCourse
     *
     * @param string $mainCourse
     * @return MenuItem
     */
    public function setMainCourse($mainCourse)
    {
        $this->mainCourse = $mainCourse;

        return $this;
    }

    /**
     * Get mainCourse
     *
     * @return string 
     */
    public function getMainCourse()
    {
        return $this->mainCourse;
    }

    /**
     * Set desert
     *
     * @param string $desert
     * @return MenuItem
     */
    public function setDesert($desert)
    {
        $this->desert = $desert;

        return $this;
    }

    /**
     * Get desert
     *
     * @return string 
     */
    public function getDesert()
    {
        return $this->desert;
    }

    /**
     * Set price
     *
     * @param string $price
     * @return MenuItem
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
     * @return MenuItem
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
     * Set vegetarian
     *
     * @param boolean $vegetarian
     * @return MenuItem
     */
    public function setVegetarian($vegetarian)
    {
        $this->vegetarian = $vegetarian;

        return $this;
    }

    /**
     * Get vegetarian
     *
     * @return boolean 
     */
    public function getVegetarian()
    {
        return $this->vegetarian;
    }

    /**
     * Set vegan
     *
     * @param boolean $vegan
     * @return MenuItem
     */
    public function setVegan($vegan)
    {
        $this->vegan = $vegan;

        return $this;
    }

    /**
     * Get vegan
     *
     * @return boolean 
     */
    public function getVegan()
    {
        return $this->vegan;
    }

    /**
     * Set restaurant
     *
     * @param \Zmittapp\ApiBundle\Entity\Restaurant $restaurant
     * @return MenuItem
     */
    public function setRestaurant(\Zmittapp\ApiBundle\Entity\Restaurant $restaurant = null)
    {
        $this->restaurant = $restaurant;

        return $this;
    }

    /**
     * Get restaurant
     *
     * @return \Zmittapp\ApiBundle\Entity\Restaurant 
     */
    public function getRestaurant()
    {
        return $this->restaurant;
    }
}
