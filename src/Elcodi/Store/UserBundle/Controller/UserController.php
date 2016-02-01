<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2016 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Feel free to edit as you please, and have fun.
 *
 * @author Marc Morera <yuhu@mmoreram.com>
 * @author Aldo Chiecchia <zimage@tiscali.it>
 * @author Elcodi Team <tech@elcodi.com>
 */

namespace Elcodi\Store\UserBundle\Controller;

use Mmoreram\ControllerExtraBundle\Annotation\Entity as EntityAnnotation;
use Mmoreram\ControllerExtraBundle\Annotation\Form as FormAnnotation;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\Response;

use Elcodi\Component\User\Entity\Interfaces\CustomerInterface;
use Elcodi\Store\CoreBundle\Controller\Traits\TemplateRenderTrait;

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
     *      path = "/user/nav",
     *      name = "store_user_nav",
     *      methods = {"GET"}
     * )
     */
    public function navAction()
    {
        $customer = $this
            ->get('elcodi.wrapper.customer')
            ->get();

        return $this->renderTemplate(
            'Subpages:user-nav.html.twig',
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
     * @Security("has_role('ROLE_CUSTOMER')")
     * @Route(
     *      path = "/user",
     *      name = "store_user",
     *      methods = {"GET"}
     * )
     */
    public function homeAction()
    {
        return $this->renderTemplate('Pages:user-home.html.twig');
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
     * @Security("has_role('ROLE_CUSTOMER')")
     * @Route(
     *      path = "/user/edit",
     *      name = "store_user_edit",
     *      methods = {"GET", "POST"}
     * )
     *
     * @EntityAnnotation(
     *      class = {
     *          "factory" = "elcodi.wrapper.customer",
     *          "method" = "get",
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
    public function editAction(
        CustomerInterface $customer,
        FormView $formView,
        $isValid
    ) {
        if ($isValid) {
            $this
                ->get('elcodi.object_manager.customer')
                ->flush($customer);

            $message = $this->get('translator')
                ->trans('store.user.profile.save.message_ok');
            $this->addFlash('success', $message);

            return $this->redirect(
                $this->generateUrl('store_user_edit')
            );
        }

        return $this->renderTemplate(
            'Pages:user-edit.html.twig',
            [
                'form' => $formView,
            ]
        );
    }
}
