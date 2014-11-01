<?php

namespace Zmittapp\ApiBundle\Controller;

use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\View\View;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest,
    FOS\RestBundle\Controller\FOSRestController,
    FOS\RestBundle\Util\Codes;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route,
    Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Zmittapp\ApiBundle\Entity\Restaurant;
use Zmittapp\ApiBundle\Exception\InvalidFormException;
use Zmittapp\ApiBundle\Form\Type\RestaurantType;

/**
 * Class UserController
 * @package Zmittapp\ApiBundle\Controller
 * @Route("/user", name="user_get")
 */
class UserController extends FOSRestController
{
    /**
     * List subscribed restaurants.
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
     * @Method("GET")
     * @Route("/{id}/subscriptions", name="user_get_subscriptions")
     * @Rest\View()
     */
    public function getSubscribedRestaurantsAction($id)
    {
        $user = $this->get('zmittapp_api.domain_manager.user')->find($id);
        return $user->getRestaurants();
    }

}
