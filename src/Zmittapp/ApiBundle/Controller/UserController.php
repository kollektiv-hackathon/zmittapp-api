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
use Zmittapp\ApiBundle\Entity\User;
use Zmittapp\ApiBundle\Exception\InvalidFormException;
use Zmittapp\ApiBundle\Form\Type\UserType;

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
     * @Route("/{uid}/subscriptions", name="user_get_subscriptions")
     * @Rest\View()
     */
    public function getSubscribedRestaurantsAction($uid)
    {
        $user = $this->get('zmittapp_api.domain_manager.user')->findOneBy(array('uid' => $uid));
        return $user->getRestaurants();
    }


    /**
     * Create a new User
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "Zmittapp\ApiBundle\Form\Type\UserType",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   }
     * )
     *
     * @Route("/", name="user_post", defaults={"_format" = "json"})
     * @Method("POST")
     * @Rest\View
     *
     */
    public function postAction(Request $request){
        try {
            $form = $this->createForm(new UserType(), new User(), array('method' => 'POST'));
            $new = $this->get('zmittapp_api.form_handler.user')->handle($form, $request);
            $routeOptions = array(
                'uid' => $new->getUid(),
                '_format' => $request->get('_format')
            );
            return $this->routeRedirectView('user_get_subscriptions', $routeOptions, Codes::HTTP_CREATED);
        }catch (InvalidFormException $exception) {
            return $exception->getForm();
        }
    }

}
