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
} 