<?php

namespace Zmittapp\ApiBundle\Controller;

use FOS\RestBundle\View\View;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest,
    FOS\RestBundle\Controller\FOSRestController,
    FOS\RestBundle\Util\Codes;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route,
    Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * Class RestaurantController
 * @package Zmittapp\ApiBundle\Controller
 * @Route("/restaurants")
 */
class RestaurantController extends Controller
{
    /**
     * List all restaurants.
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
     * @Route("/")
     * @Rest\View()
     */
    public function getRestaurantsAction()
    {
        return new View($this->getDoctrine()->getRepository('ZmittappApiBundle:Restaurant')->findAll());
    }
}
