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

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMException;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class DefaultManager {
    private $entityManager;
    private $entityName;

    public function __construct(EntityManager $entityManager, $entityName){
        $this->entityManager = $entityManager;
        $this->entityName = $entityName;
    }

    public function get($id){
        return $this->entityManager->getRepository($this->entityName)->find($id);
    }

    public function find($id){
        return $this->entityManager->getRepository($this->entityName)->find($id);
    }

    public function findAll(){
        return $this->entityManager->getRepository($this->entityName)->findAll();
    }

    public function create($entity){
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }

    public function delete($id){
        $entity = $this->find($id);
        if(!$entity){
            throw new NotFoundHttpException('Entity not found');
        }

        $this->create($entity);
    }
} 