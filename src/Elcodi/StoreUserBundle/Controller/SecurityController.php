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

use Mmoreram\ControllerExtraBundle\Annotation\Entity;
use Mmoreram\ControllerExtraBundle\Annotation\Form as AnnotationForm;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\SecurityContext;

use Elcodi\Component\Core\Services\ManagerProvider;
use Elcodi\Component\User\Entity\Interfaces\CustomerInterface;
use Elcodi\StoreCoreBundle\Controller\Traits\TemplateRenderTrait;

/**
 * Class SecurityController
 */
class SecurityController extends Controller
{
    use TemplateRenderTrait;

    /**
     * Login page
     *
     * @param FormView $loginFormView Login form view
     *
     * @return Response Response
     *
     * @Route(
     *      path = "/login",
     *      name = "store_login",
     *      methods = {"GET"}
     * )
     *
     * @AnnotationForm(
     *      class = "store_user_form_type_login",
     *      name  = "loginFormView"
     * )
     */
    public function loginAction(FormView $loginFormView)
    {
        /**
         * If user is already logged, go to redirect url
         */
        if ($this->get('security.context')->isGranted('ROLE_CUSTOMER')) {
            return new RedirectResponse($this->generateUrl('store_homepage'));
        }

        /**
         * Checking for authentication errors in session
         */
        if ($this->get('session')->has(SecurityContext::AUTHENTICATION_ERROR)) {

            $this->get('session')
                ->getFlashBag()
                ->add('error', 'Wrong Email and password combination.');
        }

        return $this->renderTemplate(
            'User:login.html.twig',
            [
                'form' => $loginFormView,
            ]
        );
    }

    /**
     * Register page
     *
     * @param CustomerInterface $customer         empty customer
     * @param FormView          $registerFormView Register form type
     * @param boolean           $isValid          Form submition is valid
     *
     * @return Response Response
     *
     * @Route(
     *      path = "/register",
     *      name = "store_register",
     *      methods = {"GET", "POST"}
     * )
     *
     * @Entity(
     *      name     = "customer",
     *      class    = {
     *          "factory"  = "elcodi.core.user.factory.customer"
     *      },
     *      persist  = false
     * )
     * @AnnotationForm(
     *      class         = "store_user_form_type_register",
     *      entity        = "customer",
     *      handleRequest = true,
     *      name          = "registerFormView",
     *      validate      = "isValid"
     * )
     */
    public function registerAction(
        CustomerInterface $customer,
        FormView $registerFormView,
        $isValid
    )
    {
        if ($isValid) {

            /**
             * @var ManagerProvider $managerProvider
             */
            $managerProvider = $this->get('elcodi.manager_provider');
            $customerManager = $managerProvider->getManagerByEntityParameter('elcodi.core.user.entity.customer.class');
            $customerManager->persist($customer);
            $customerManager->flush($customer);

            $this
                ->get('elcodi.core.user.service.customer_manager')
                ->register($customer, 'customer_secured_area');

            return $this->redirect($this->generateUrl('store_homepage'));
        }

        return $this->renderTemplate(
            'User:register.html.twig',
            [
                'form' => $registerFormView,
            ]
        );
    }
}
