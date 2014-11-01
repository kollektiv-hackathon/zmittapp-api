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
 * Class RestaurantController
 * @package Zmittapp\ApiBundle\Controller
 * @Route("/restaurants", name="restaurant_get")
 */
class RestaurantController extends FOSRestController
{
    /**
     * Unsubscribe a restaurant from favorites (as a user)
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful"
     *   }
     * )
     *
     *
     * @Rest\QueryParam(name="lat", nullable=false, description="Latitude of current user location.")
     * @Rest\QueryParam(name="lon", nullable=false, description="Longitude of current user location.")
     *
     * @return array
     *
     * @Method("GET")
     * @Route("/location", name="restaurant_location")
     * @Rest\View()
     *
     */
    public function locationAction(ParamFetcherInterface $paramFetcher)
    {
        $lat = $paramFetcher->get('lat');
        $lon = $paramFetcher->get('lon');

        $restaurants = $this->get('zmittapp_api.domain_manager.restaurant')->findAll();
        $arr = array();
        $i = 0;
        foreach($restaurants as $restaurant) {
            $arr[$i][0] = $restaurant;
            $arr[$i][1] = array('distance' => $this->distance($restaurant->getLat(), $restaurant->getLon(), $lat, $lon));
            $i++;
        }
        return $arr;
    }


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
     * @Route("/", name="restaurant_all")
     * @Rest\View()
     */
    public function getRestaurantsAction()
    {
        return $this->get('zmittapp_api.domain_manager.restaurant')->findAll();
    }

    /**
     * List restaurant detail.
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
     * @Route("/{id}", name="restaurant_get")
     * @Rest\View()
     */
    public function getAllRestaurantsAction($id)
    {
        return $this->get('zmittapp_api.domain_manager.restaurant')->find($id);
    }

    /**
     * Create a new Restaurant
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
     * @Route("/", name="restaurant_post", defaults={"_format" = "json"})
     * @Method("POST")
     * @Rest\View
     *
     */
    public function postRestaurantsAction(Request $request){
        try {
            $formHandler = $this->get('zmittapp_api.form.handler.create_restaurant');
            $form = $this->createForm(new RestaurantType(), new Restaurant(), array('method' => 'POST'));
            $newRestaurant = $formHandler->handle($form, $request);
            $routeOptions = array(
                'id' => $newRestaurant->getId(),
                '_format' => $request->get('_format')
            );
            return $this->routeRedirectView('restaurant_get', $routeOptions, Codes::HTTP_CREATED);
        }catch (InvalidFormException $exception) {
            return $exception->getForm();
        }
    }

    /**
     * List all menu items for a restaurant.
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
     * @Route("/{id}/menuitems", name="restaurant_get_menuitems")
     * @Rest\View()
     */
    public function getMenuItemsAction($id)
    {
        $restaurant = $this->get('zmittapp_api.domain_manager.restaurant')->find($id);
        return $restaurant->getMenuItems();
    }


    /**
     * Subscribe a restaurant to favorites (as a user)
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
     * @Route("/{id}/subscribe/{userId}", name="restaurant_subscribe")
     * @Rest\View()
     */
    public function subscribeUserAction($id, $userId)
    {
        $restaurantManager = $this->get('zmittapp_api.domain_manager.restaurant');
        $restaurant = $restaurantManager->find($id);

        $userManager = $this->get('zmittapp_api.domain_manager.user');
        $user = $userManager->find($userId);

        //TODO: checks
        $user->addRestaurant($restaurant);
        $userManager->create($user);

        return true;
    }

    /**
     * Unsubscribe a restaurant from favorites (as a user)
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
     * @Route("/{id}/unsubscribe/{userId}", name="restaurant_unsubscribe")
     * @Rest\View()
     */
    public function unsubscribeUserAction($id, $userId)
    {
        $restaurantManager = $this->get('zmittapp_api.domain_manager.restaurant');
        $restaurant = $restaurantManager->find($id);

        $userManager = $this->get('zmittapp_api.domain_manager.user');
        $user = $userManager->find($userId);

        //TODO: checks
        $user->removeRestaurant($restaurant);
        $userManager->create($user);

        return true;
    }



    private function distance($lat1, $lon1, $lat2, $lon2) {
        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        return ($miles * 1.609344);
    }


}
