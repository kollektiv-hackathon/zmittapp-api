<?php
/*
 * This file is part of the [name] package.
 *
 * (c) Marc Juchli <mail@marcjuch.li>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zmittapp\ApiBundle\Form\Handler;

use Codag\RestFabricationBundle\Form\Handler\CreateFormHandler;
use Codag\RestFabricationBundle\DomainManager\DomainManagerInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Codag\RestFabricationBundle\Exception\InvalidFormException;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;
use Zmittapp\AuthBundle\Entity\Owner;

class CreateRestaurantFormHandler extends CreateFormHandler {

    private $manager;

    private $encoderFactory;

    public function __construct(DomainManagerInterface $manager, EncoderFactoryInterface $encoderFactory){
        $this->manager = $manager;
        $this->encoderFactory = $encoderFactory;
    }

    /**
     * @param FormInterface $form
     * @param Request $request
     * @return Entity
     * @throws InvalidFormException
     */
    public function handle(FormInterface $form, Request $request){
        $form->submit($request, 'PATCH' !== $request->getMethod());

        if($form->isValid()){
            $validData = $form->getData();
            $this->encryptPassword($validData->getOwner());
            $this->manager->create($validData);

            return $validData;
        }

        throw new InvalidFormException('Invalid submitted data', $form);
    }

    private function encryptPassword(Owner $owner){
        $encoder = $this->encoderFactory->getEncoder($owner);
        $password = $encoder->encodePassword($owner->getPassword(), $owner->getSalt());
        $owner->setPassword($password);
    }
} 