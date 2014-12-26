<?php

namespace Zmittapp\ApiBundle\Controller;

use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations as Rest,
    FOS\RestBundle\Controller\FOSRestController,
    FOS\RestBundle\Util\Codes;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route,
    Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Zmittapp\ApiBundle\Entity\MenuItem;
use Zmittapp\ApiBundle\Entity\Restaurant;
use Zmittapp\ApiBundle\Entity\RestaurantLocation;
use Zmittapp\ApiBundle\Form\Type\MenuItemType;
use Zmittapp\ApiBundle\Form\Type\RestaurantType;

use Codag\RestFabricationBundle\Exception\InvalidFormException,
    Codag\RestFabricationBundle\Exception\ResourceNotFoundException;

/**
 * Class ProfileController
 * @package Zmittapp\ApiBundle\Controller
 * @Route("/profile")
 */
class ProfileController extends FOSRestController
{
    /**
     * List profile detail.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful"
     *   }
     * )
     *
     * @return array
     *
     * @Route("", name="profile_get")
     * @Method("GET")
     *
     * @Rest\View(serializerGroups={"owner"})
     */
    public function getAction()
    {
        $user = $this->get('security.context')->getToken()->getUser();

        $restaurant = $user->getRestaurant();
        if(!$restaurant){
            throw new ResourceNotFoundException('No restaurant profile attached for User', $user->getId());
        }

        return $restaurant;
    }


}
