<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Feel free to edit as you please, and have fun.
 *
 * @author Marc Morera <yuhu@mmoreram.com>
 * @author Aldo Chiecchia <zimage@tiscali.it>
 */

namespace Elcodi\StoreUserBundle\Controller;

use Mmoreram\ControllerExtraBundle\Annotation\Entity as EntityAnnotation;
use Mmoreram\ControllerExtraBundle\Annotation\Form as FormAnnotation;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\Response;

use Elcodi\Component\User\Entity\Interfaces\CustomerInterface;
use Elcodi\StoreCoreBundle\Controller\Traits\TemplateRenderTrait;

/**
 * Class UserController
 */
class UserController extends Controller
{
    use TemplateRenderTrait;

    /**
     * Customer bar in top position
     *
     * @return array
     *
     * @Route(
     *      path = "/user/top",
     *      name = "store_user_top",
     *      methods = {"GET"}
     * )
     */
    public function topAction()
    {
        $customer = $this
            ->get('elcodi.core.user.wrapper.customer_wrapper')
            ->loadCustomer();

        return $this->renderTemplate(
            'User:_topbar.html.twig',
            [
                'customer' => $customer,
            ]
        );
    }

    /**
     * User page
     *
     * @return array
     *
     * @Route(
     *      path = "/user",
     *      name = "store_user",
     *      methods = {"GET"}
     * )
     */
    public function userAction()
    {
        return $this->renderTemplate('User:user.html.twig');
    }

    /**
     * User profile page
     *
     * @param CustomerInterface $customer Customer
     * @param FormView          $formView Form view
     * @param string            $isValid  Is valid
     *
     * @return Response Response
     *
     * @Route(
     *      path = "/user/profile",
     *      name = "store_user_profile",
     *      methods = {"GET"}
     * )
     *
     * @EntityAnnotation(
     *      class = {
     *          "factory" = "elcodi.customer_wrapper",
     *          "method" = "loadCustomer",
     *          "static" = false
     *      },
     *      name = "customer",
     * )
     * @FormAnnotation(
     *      class         = "store_user_form_type_profile",
     *      name          = "formView",
     *      entity        = "customer",
     *      handleRequest = true,
     *      validate      = "isValid"
     * )
     */
    public function profileAction(
        CustomerInterface $customer,
        FormView $formView,
        $isValid
    )
    {
        if ($isValid) {

            $this
                ->get('elcodi.object_manager.customer')
                ->flush($customer);

            return $this->redirect(
                $this->generateUrl('store_user_profile')
            );
        }

        return $this->renderTemplate(
            'User:profile.html.twig',
            [
                'form' => $formView,
            ]
        );
    }
}
