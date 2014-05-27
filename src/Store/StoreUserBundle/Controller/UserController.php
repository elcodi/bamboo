<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * This distribution is just a basic e-commerce implementation based on
 * Elcodi project.
 *
 * Feel free to edit it, and make your own
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author ##author_placeholder
 * @version ##version_placeholder##
 */

namespace Store\StoreUserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Form;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Mmoreram\ControllerExtraBundle\Annotation\Form as AnnotationForm;

/**
 * Class UserController
 */
class UserController extends Controller
{
    /**
     * Customer bar in top position
     *
     * @return array
     *
     * @Route(
     *      path = "/user/top",
     *      name = "store_user_top"
     * )
     * @Template
     */
    public function topAction()
    {
        $customer = $this
            ->get('elcodi.core.user.wrapper.customer_wrapper')
            ->loadCustomer();

        return [
            'customer' => $customer,
        ];
    }

    /**
     * User page
     *
     * @return array
     *
     * @Route(
     *      path = "/user",
     *      name = "store_user"
     * )
     * @Template
     */
    public function userAction()
    {
        return [];
    }

    /**
     * User profile page
     *
     * @param Request      $request         Request
     * @param AbstractType $profileFormType Profile form type
     *
     * @return array
     *
     * @Route(
     *      path = "/user/profile",
     *      name = "store_user_profile"
     * )
     * @Template
     *
     * @AnnotationForm(
     *      class         = "store_user_form_type_profile",
     *      name          = "profileFormType",
     * )
     */
    public function profileAction(Request $request, AbstractType $profileFormType)
    {
        $customer = $this
            ->get('elcodi.core.user.wrapper.customer_wrapper')
            ->loadCustomer();

        /**
         * @var Form $form
         */
        $form = $this
            ->get('form.factory')
            ->create($profileFormType, $customer);

        $form->handleRequest($request);

        if ($form->isValid()) {

            $this
                ->get('elcodi.manager_provider')
                ->getManagerByEntityParameter('elcodi.core.user.entity.customer.class')
                ->flush($customer);

            return $this->redirect($this->generateUrl('store_user_profile'));
        }

        return [
            'form' => $form->createView(),
        ];
    }
}
