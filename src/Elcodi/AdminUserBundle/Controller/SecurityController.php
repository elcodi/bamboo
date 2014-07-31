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

namespace Elcodi\AdminUserBundle\Controller;

use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Mmoreram\ControllerExtraBundle\Annotation\Form as AnnotationForm;

/**
 * Class SecurityController
 */
class SecurityController extends Controller
{
    /**
     * Login page
     *
     * @param FormView $loginFormView Login form view
     *
     * @return array
     *
     * @Route(
     *      path = "/login",
     *      name = "admin_login"
     * )
     * @Template
     *
     * @AnnotationForm(
     *      class = "admin_user_form_type_login",
     *      name  = "loginFormView"
     * )
     */
    public function loginAction(FormView $loginFormView)
    {
        /**
         * If user is already logged, go to redirect url
         */
        if ($this->get('security.context')->isGranted('ROLE_ADMIN')) {
            return new RedirectResponse($this->generateUrl('admin_homepage'));
        }

        return [
            'form' => $loginFormView,
        ];
    }
}
