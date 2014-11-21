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
use Zmittapp\ApiBundle\Entity\User;


class LoadRestaurantData extends AbstractFixture implements OrderedFixtureInterface {

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $restaurant = new Restaurant();
        $restaurant->setName('Kronenhalle');
        $restaurant->setAddress('Rämistrasse 4');
        $restaurant->setZip('8001');
        $restaurant->setCity('Zürich');
        $restaurant->setCountry('CH');
        $restaurant->setEmail('info@kornenhalle.ch');
        $restaurant->setPhone('+41 44 262 99 00');
        $restaurant->setLat(47.3676249);
        $restaurant->setLon(8.5458653);

        $restaurant2 = new Restaurant();
        $restaurant2->setName('Aubrey');
        $restaurant2->setAddress('Schiffbaustrasse 10');
        $restaurant2->setZip('8005');
        $restaurant2->setCity('Zürich');
        $restaurant2->setCountry('CH');
        $restaurant2->setEmail('info@kornenhalle.ch');
        $restaurant2->setPhone('+41 44 440 00 20');
        $restaurant2->setLat(47.3891168);
        $restaurant2->setLon(8.5177954);

        $restaurant3 = new Restaurant();
        $restaurant3->setName('les halles');
        $restaurant3->setAddress('Pfingstweidstrasse 6');
        $restaurant3->setZip('8005');
        $restaurant3->setCity('Zürich');
        $restaurant3->setCountry('CH');
        $restaurant3->setEmail('info@leshalles.ch');
        $restaurant3->setPhone('+41 44 440 00 20');
        $restaurant3->setLat(47.3882397);
        $restaurant3->setLon(8.5186537);

        $restaurant4 = new Restaurant();
        $restaurant4->setName('Brasserie Lipp');
        $restaurant4->setAddress('Uraniastrasse 9');
        $restaurant4->setZip('8001');
        $restaurant4->setCity('Zürich');
        $restaurant4->setCountry('CH');
        $restaurant4->setEmail('info@lipp.ch');
        $restaurant4->setPhone('+41 44 440 00 20');
        $restaurant4->setLat(47.3744784);
        $restaurant4->setLon(8.5395551);

        $restaurant5 = new Restaurant();
        $restaurant5->setName('Bärengasse');
        $restaurant5->setAddress('Bahnhofstrasse 25');
        $restaurant5->setZip('8001');
        $restaurant5->setCity('Zürich');
        $restaurant5->setCountry('CH');
        $restaurant5->setEmail('info@restaurant-baerengasse.ch');
        $restaurant5->setPhone('+41 44 440 00 20');
        $restaurant5->setLat(47.3707062);
        $restaurant5->setLon(8.539184);

        $manager->persist($restaurant);
        $manager->persist($restaurant2);
        $manager->persist($restaurant3);
        $manager->persist($restaurant4);
        $manager->persist($restaurant5);

        $menuItem1 = new MenuItem();
        $menuItem1->setDate(new \DateTime());
        $menuItem1->setAppetizer('Gemischter Salat');
        $menuItem1->setMainCourse('Kalbsgeschnetzeltes mit Rösti');
        $menuItem1->setDesert('Schokoladen Mousse');
        $menuItem1->setPrice(65.50);
        $menuItem1->setVegan(false);
        $menuItem1->setVegetarian(false);
        $menuItem1->setRestaurant($restaurant);

        $menuItem2 = new MenuItem();
        $menuItem2->setDate(new \DateTime());
        $menuItem2->setAppetizer('Suppe');
        $menuItem2->setMainCourse('Tofu Tatar');
        $menuItem2->setDesert('Apfel');
        $menuItem2->setPrice(19.95);
        $menuItem2->setVegan(false);
        $menuItem2->setVegetarian(true);
        $menuItem2->setRestaurant($restaurant);

        $menuItem3 = new MenuItem();
        $menuItem3->setDate(new \DateTime());
        $menuItem3->setAppetizer('Gemüsesuppe');
        $menuItem3->setMainCourse('Veganer Kebab');
        $menuItem3->setDesert('Kokusnuss Mousse');
        $menuItem3->setPrice(23.50);
        $menuItem3->setVegan(true);
        $menuItem3->setVegetarian(true);
        $menuItem3->setRestaurant($restaurant2);

        $menuItem4 = new MenuItem();
        $menuItem4->setDate(new \DateTime());
        $menuItem4->setAppetizer('Grillgemüse');
        $menuItem4->setMainCourse('Reis');
        $menuItem4->setDesert('Birne');
        $menuItem4->setPrice(30.00);
        $menuItem4->setVegan(true);
        $menuItem4->setVegetarian(true);
        $menuItem4->setRestaurant($restaurant2);

        $manager->persist($menuItem1);
        $manager->persist($menuItem2);
        $manager->persist($menuItem3);
        $manager->persist($menuItem4);


        $user1 = new User();
        $user1->setUid("11CF2061-9BC4-4D80-9C1B-A1055EF25455");
        $user1->addRestaurant($restaurant);
        $user1->addRestaurant($restaurant3);

        $user2 = new User();
        $user2->setUid("11CF2061-9BC4-4D80-9C1B-A1055EF25456");
        $user2->addRestaurant($restaurant);
        $user2->addRestaurant($restaurant4);
        $user2->addRestaurant($restaurant5);

        $user3 = new User();
        $user3->setUid("11CF2061-9BC4-4D80-9C1B-A1055EF25457");
        $user3->addRestaurant($restaurant);
        $user3->addRestaurant($restaurant3);
        $user3->addRestaurant($restaurant5);

        $manager->persist($user1);
        $manager->persist($user2);
        $manager->persist($user3);

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