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

} 