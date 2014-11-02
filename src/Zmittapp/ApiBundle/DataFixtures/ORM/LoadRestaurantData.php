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
use Zmittapp\ApiBundle\Entity\MenuItem;
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
        $restaurant->setPhone('+41 44 262 99 00');
        $restaurant->setLat(47.367584);
        $restaurant->setLon(8.545758);

        $restaurant2 = new Restaurant();
        $restaurant2->setName('Aubrey');
        $restaurant2->setEmail('info@kornenhalle.ch');
        $restaurant2->setPhone('+41 44 440 00 20');
        $restaurant2->setLat(47.389125);
        $restaurant2->setLon(8.517664);

        $manager->persist($restaurant);
        $manager->persist($restaurant2);

        $menuItem1 = new MenuItem();
        $menuItem1->setDate('');
        $menuItem1->setAppetizer('Gemischter Salat');
        $menuItem1->setMainCourse('Kalbsgeschnetzeltes mit Rösti');
        $menuItem1->setDesert('Schokoladen Mousse');
        $menuItem1->setPrice(65.50);
        $menuItem1->setVegan(false);
        $menuItem1->setVegetarian(false);
        $menuItem1->setRestaurant($restaurant);

        $menuItem2 = new MenuItem();
        $menuItem2->setDate('');
        $menuItem2->setAppetizer('Suppe');
        $menuItem2->setMainCourse('Tofu Tatar');
        $menuItem2->setDesert('Apfel');
        $menuItem2->setPrice(19.95);
        $menuItem2->setVegan(false);
        $menuItem2->setVegetarian(true);
        $menuItem2->setRestaurant($restaurant);

        $manager->persist($menuItem1);
        $manager->persist($menuItem2);

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