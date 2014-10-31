<?php
/*
 * This file is part of the [name] package.
 *
 * (c) Marc Juchli <mail@marcjuch.li>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zmittapp\ApiBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Zmittapp\ApiBundle\Entity\Restaurant;


class LoadRestaurantData extends AbstractFixture implements OrderedFixtureInterface {

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $restaurant = new Restaurant();
        $restaurant->setName('Kronenhalle');
        $restaurant->setEmail('info@kornenhalle.ch');
        $restaurant->setPhone('044 666 66 66');
        $restaurant->setLat(11);
        $restaurant->setLon(12);

        $manager->persist($restaurant);
        $manager->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 1; // the order in which fixtures will be loaded
    }
} 