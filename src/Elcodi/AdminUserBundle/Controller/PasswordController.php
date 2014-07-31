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

use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Mmoreram\ControllerExtraBundle\Annotation\Form as AnnotationForm;

use Elcodi\UserBundle\Entity\Abstracts\AbstractUser;

/**
 * Class PasswordController
 *
 * @Route(
 *      path = "/password",
 * )
 */
class PasswordController extends Controller
{
    /**
     * Remember password
     *
     * @param Form    $passwordRememberForm Password remember form
     * @param boolean $isValid              Is valid
     *
     * @return array
     *
     * @Route(
     *      path = "/remember",
     *      name = "admin_password_remember"
     * )
     * @Template
     *
     * @AnnotationForm(
     *      class         = "admin_user_form_type_password_remember",
     *      handleRequest = true,
     *      name          = "passwordRememberForm",
     *      validate      = "isValid"
     * )
     */
    public function rememberAction(Form $passwordRememberForm, $isValid)
    {
        if ($isValid) {

            $adminUserRepository = $this
                ->get('elcodi.repository_provider')
                ->getRepositoryByEntityParameter('elcodi.core.user.entity.admin_user.class');

            $email = $passwordRememberForm->getData()['email'];
            $emailFound = $this
                ->get('elcodi.core.user.service.password_manager')
                ->rememberPasswordByEmail(
                    $adminUserRepository,
                    $email,
                    'admin_password_recover'
                );

            if ($emailFound) {
                return new RedirectResponse(
                    $this->generateUrl('admin_password_recover_sent')
                );
            }
        }

        return [
            'form' => $passwordRememberForm->createView(),
        ];
    }

    /**
     * Recover password sent action
     *
     * @return array
     *
     * @Route(
     *      path = "/sent",
     *      name = "admin_password_recover_sent"
     * )
     * @Template
     */
    public function sentAction()
    {
        /**
         * If user is already logged, go to redirect url
         */
        if ($this->get('security.context')->isGranted('ROLE_ADMIN')) {
            return new RedirectResponse($this->generateUrl('admin_homepage'));
        }

        return [];
    }

    /**
     * Recover password
     *
     * @param Form    $passwordRecoverForm Password recover form
     * @param string  $hash                Hash
     * @param boolean $isValid             Is valid
     *
     * @return array
     *
     * @Route(
     *      path = "/recover/{hash}",
     *      name = "admin_password_recover",
     *      requirements = {
     *          "hash" = "[\dA-Fa-f]+"
     *      }
     * )
     * @Template
     *
     * @AnnotationForm(
     *      class         = "admin_user_form_type_password_recover",
     *      handleRequest = true,
     *      name          = "passwordRecoverForm",
     *      validate      = "isValid"
     * )
     */
    public function recoverAction(Form $passwordRecoverForm, $isValid, $hash)
    {
        if ($isValid) {

            $customer = $this
                ->get('elcodi.repository.admin_user')
                ->findOneBy(array(
                    'recoveryHash' => $hash,
                ));

            if ($customer instanceof AbstractUser) {

                $password = $passwordRecoverForm->getData()['password'];

                $this
                    ->get('elcodi.core.user.service.password_manager')
                    ->recoverPassword($customer, $hash, $password);

                return new RedirectResponse($this->generateUrl('admin_homepage'));
            }
        }

        return array(
            'form' => $passwordRecoverForm->createView()
        );
    }
}
