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
     **/
    private $users;

    /**
     * @var array
     *
     * @ORM\OneToMany(targetEntity="MenuItem", mappedBy="restaurant")
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
     * @ORM\Column(name="long", type="decimal")
     * @Assert\NotBlank(message="long is missing!")
     *
     */
    private $long;

    public function __construct() {
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
    }
} 