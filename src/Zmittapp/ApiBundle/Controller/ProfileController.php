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

use Symfony\Component\Security\Core\Exception\AccessDeniedException;
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

    /**
     * Create a new restaurant profile
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "Zmittapp\ApiBundle\Form\Type\RestaurantType",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   }
     * )
     *
     * @Route("", name="profile_post", defaults={"_format" = "json"})
     * @Method("POST")
     * @Rest\View
     *
     */
    public function postAction(Request $request){
        try {
            $form = $this->createForm(new RestaurantType(), new Restaurant(), array('method' => 'POST'));
            $new = $this->get('zmittapp_api.form_handler.restaurant')->handle($form, $request);
            $routeOptions = array(
                'id' => $new->getId(),
                '_format' => $request->get('_format')
            );
            return $this->routeRedirectView('profile_get', $routeOptions, Codes::HTTP_CREATED);
        }catch (InvalidFormException $exception) {
            return $exception->getForm();
        }
    }

    /**
     * Update an existing Restaurant
     *
     * @ApiDoc(
     *  description="Update an existing Restaurant",
     *  input = "Zmittapp\ApiBundle\Form\Type\RestaurantType",
     *  statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the Restaurant not found"
     *  }
     * )
     *
     * @Route("/{id}", name="restaurant_put", defaults={"_format" = "json"})
     * @Method("PUT")
     * @Rest\View
     */
    public function putAction(Request $request, $id){
        try {
            $manager = $this->get('zmittapp_api.domain_manager.restaurant');
            $formHandler = $this->get('zmittapp_api.form_handler.restaurant');

            if (!($object = $manager->get($id))) {
                $statusCode = Codes::HTTP_CREATED;
                $form = $this->createForm(new RestaurantType(), new Restaurant(), array('method' => 'POST'));
            } else {
                $user = $this->get('security.context')->getToken()->getUser();
                $restaurant = $user->getRestaurant();
                if($restaurant->getId() != $id){
                   throw new AccessDeniedException('Restaurant does not belong to this account.');
                }
                $statusCode = Codes::HTTP_NO_CONTENT;
                $form = $this->createForm(new RestaurantType(), $object, array('method' => 'PUT'));
            }

            $object = $formHandler->handle($form, $request);

            $routeOptions = array(
                'id' => $object->getId(),
                '_format' => $request->get('_format')
            );

            return $this->routeRedirectView('profile_get', $routeOptions, $statusCode);

        } catch (InvalidFormException $exception) {
            return $exception->getForm();
        }
    }

}
