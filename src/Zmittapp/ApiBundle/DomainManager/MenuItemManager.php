<?php
/*
 * This file is part of the [name] package.
 *
 * (c) Marc Juchli <mail@marcjuch.li>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zmittapp\ApiBundle\DomainManager;

use Zmittapp\ApiBundle\Entity\Restaurant;
use Codag\RestFabricationBundle\Exception\ResourceNotFoundException;
use Codag\RestFabricationBundle\DomainManager\DefaultManager;

class MenuItemManager extends DefaultManager {

    public function findUpcomingItems(Restaurant $restaurant, $days){
        $now = new \DateTime();
        $now->setTime(0, 0, 0);

        $endDate = new \DateTime();
        $endDate->setTime(0, 0, 0);
        $endDate->add(new \DateInterval('P'.$days.'D'));

        $qb =$this->entityManager->getRepository($this->entityName)->createQueryBuilder('m');
        $qb->select('m')
            ->where('m.restaurant = :restaurant')
            ->andWhere('m.date >= :startDate')
            ->andWhere('m.date < :endDate')
            ->setParameter('restaurant', $restaurant)
            ->setParameter('startDate', $now)
            ->setParameter('endDate', $endDate->format('Y-m-d'))
            ;

        try {
            return $qb->getQuery()->getResult();
        } catch (\Doctrine\ORM\NoResultException $e) {
            throw new ResourceNotFoundException('Entity', "");
        }
    }


} 