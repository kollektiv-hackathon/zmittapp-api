<?php
/*
 * This file is part of the [name] package.
 *
 * (c) Marc Juchli <mail@marcjuch.li>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mittag\ApiBundle\Entity;

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

} 