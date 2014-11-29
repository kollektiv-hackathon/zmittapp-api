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
    Codag\RestFabricationBundle\Exception\RessourceNotFoundException;

/**
 * Class RestaurantController
 * @package Zmittapp\ApiBundle\Controller
 * @Route("/restaurants", name="restaurant_get")
 */
class RestaurantController extends FOSRestController
{
    /**
     * List all restaurants with it's distance to users current location
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
            $restaurantLocation = $restaurant->castToRestaurantLocation();
            $restaurantLocation->setDistance($this->distance($restaurant->getLat(), $restaurant->getLon(), $lat, $lon));
            $arr[$i] = $restaurantLocation;
            $i++;
        }

        $locationComparator = function(RestaurantLocation $r1, RestaurantLocation $r2){
            if ($r1->getDistance() == $r2->getDistance()) {
                return 0;
            }
            return ($r1->getDistance() < $r2->getDistance()) ? -1 : 1;
        };

        usort($arr, $locationComparator);

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
        $restaurant = $this->get('zmittapp_api.domain_manager.restaurant')->find($id);
        if(!$restaurant){
            throw new NotFoundHttpException('Restaurant not found with id: '. $id);
        }
        return $restaurant;
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
            $form = $this->createForm(new RestaurantType(), new Restaurant(), array('method' => 'POST'));
            $new = $this->get('zmittapp_api.form_handler.restaurant')->handle($form, $request);
            $routeOptions = array(
                'id' => $new->getId(),
                '_format' => $request->get('_format')
            );
            return $this->routeRedirectView('restaurant_get', $routeOptions, Codes::HTTP_CREATED);
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
    public function putRestaurantsAction(Request $request, $id){
        try {
            $manager = $this->get('zmittapp_api.domain_manager.restaurant');
            $formHandler = $this->get('zmittapp_api.form_handler.restaurant');

            if (!($object = $manager->get($id))) {
                $statusCode = Codes::HTTP_CREATED;
                $form = $this->createForm(new RestaurantType(), new Restaurant(), array('method' => 'POST'));
            } else {
                $statusCode = Codes::HTTP_NO_CONTENT;
                $form = $this->createForm(new RestaurantType(), $object, array('method' => 'PUT'));
            }

            $object = $formHandler->handle($form, $request);

            $routeOptions = array(
                'id' => $object->getId(),
                '_format' => $request->get('_format')
            );

            return $this->routeRedirectView('restaurant_get', $routeOptions, $statusCode);

        } catch (InvalidFormException $exception) {
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
        if(!$restaurant){
            throw new NotFoundHttpException('Restaurant not found with id: '. $id);
        }

        return $this->get('zmittapp_api.domain_manager.menuitem')->findUpcomingItems($restaurant, 2);
    }

    /**
     * Create a new Menu Item
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "Zmittapp\ApiBundle\Form\Type\MenuItemType",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   }
     * )
     *
     * @Route("/{id}/menuitems", name="restaurant_menuitem_post", defaults={"_format" = "json"})
     * @Method("POST")
     * @Rest\View
     *
     */
    public function postMenuItemAction(Request $request){
        try {
            $form = $this->createForm(new MenuItemType(), new MenuItem(), array('method' => 'POST'));
            $new = $this->get('zmittapp_api.form_handler.menuitem')->handle($form, $request);
            $routeOptions = array(
                'id' => $new->getRestaurant()->getId(),
                '_format' => $request->get('_format')
            );
            return $this->routeRedirectView('restaurant_get', $routeOptions, Codes::HTTP_CREATED);
        }catch (InvalidFormException $exception) {
            return $exception->getForm();
        }
    }

    /**
     * Update an existing menu item
     *
     * @ApiDoc(
     *  input = "Zmittapp\ApiBundle\Form\Type\MenuItemType",
     *  statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the Restaurant not found"
     *  }
     * )
     *
     * @Route("/{id}/menuitems/{itemId}", name="restaurant_put_menuitems", defaults={"_format" = "json"})
     * @Method("PUT")
     * @Rest\View
     */
    public function putMenuItemsAction(Request $request, $id, $itemId){
        try {
            $manager = $this->get('zmittapp_api.domain_manager.menuitem');
            $formHandler = $this->get('zmittapp_api.form_handler.menuitem');

            if (!($object = $manager->get($itemId))) {
                $statusCode = Codes::HTTP_CREATED;
                $form = $this->createForm(new MenuItemType(), new MenuItem(), array('method' => 'POST'));
            } else {
                $statusCode = Codes::HTTP_NO_CONTENT;
                $form = $this->createForm(new MenuItemType(), $object, array('method' => 'PUT'));
            }

            $object = $formHandler->handle($form, $request);

            $routeOptions = array(
                'id' => $object->getId(),
                '_format' => $request->get('_format')
            );

            return $this->routeRedirectView('restaurant_get_menuitems', $routeOptions, $statusCode);

        } catch (InvalidFormException $exception) {
            return $exception->getForm();
        }
    }


    /**
     *
     * @ApiDoc(
     *  description="Deletes an existing menuitem",
     *  statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the menuitem not found"
     *  }
     * )
     *
     * @Route("/{id}/menuitems/{itemId}", name="restaurant_menuitems_delete", defaults={"_format" = "json"})
     * @Method("DELETE")
     *
     */
    public function deleteAction(Request $request, $itemId) {
        $manager = $this->get('zmittapp_api.domain_manager.menuitem');
        $obj = $manager->find($itemId);
        if(!$obj){
            throw new RessourceNotFoundException('MenuItem', $itemId);
        }
        $manager->delete($itemId);

        $routeOptions = array(
            'id' => $obj->getRestaurant()->getId(),
            '_format' => $request->get('_format')
        );

        return $this->routeRedirectView('restaurant_get', $routeOptions, Codes::HTTP_NO_CONTENT);
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
     * @Method("PUT")
     * @Route("/{id}/subscribe/{userId}", name="restaurant_subscribe")
     * @Rest\View()
     */
    public function subscribeUserAction($id, $userId)
    {
        $restaurant = $this->get('zmittapp_api.domain_manager.restaurant')->find($id);
        if(!$restaurant){
            throw new RessourceNotFoundException('Restaurant', $id);
        }

        $userManager = $this->get('zmittapp_api.domain_manager.user');
        $user = $userManager->findOneBy(array('uid' => $userId));
        if(!$user){
            throw new RessourceNotFoundException('User', $userId);
        }

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
     * @Method("PUT")
     * @Route("/{id}/unsubscribe/{userId}", name="restaurant_unsubscribe")
     * @Rest\View()
     */
    public function unsubscribeUserAction($id, $userId)
    {
        $restaurant = $this->get('zmittapp_api.domain_manager.restaurant')->find($id);
        if(!$restaurant){
            throw new RessourceNotFoundException('Restaurant', $id);
        }

        $userManager = $this->get('zmittapp_api.domain_manager.user');
        $user = $userManager->findOneBy(array('uid' => $userId));
        if(!$user){
            throw new RessourceNotFoundException('User', $userId);
        }

        //TODO: checks
        $user->removeRestaurant($restaurant);
        $userManager->save($user);

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
